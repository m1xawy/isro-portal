<?php

namespace App\Http\Controllers\Donate;

use App\Models\Donate\DonationPayOp;
use App\Helpers\Donate\PayOp\PayOpHelper;
use App\Http\Controllers\Controller;
use App\Models\SRO\Portal\AphChangedSilk;
use App\Models\Donate\PayOpInvoices;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DonationsPayOpController extends Controller
{

    /**
     * @return RedirectResponse
     * @throws Exception
     */
    public function buy(int $id, Request $request)
    {
        $package = DonationPayOp::query()
            ->where('id', $id)
            ->firstOrFail();

        $user = $request->user();
        $payload = Str::random(20);
        DB::beginTransaction();
        try {
            $order = PayOpInvoices::query()
                ->create([
                    'user_id' => $user->id,
                    'payload' => $payload,
                    'name' => $package->name,
                    'price' => $package->price,
                    'silk' => $package->silk,
                    'state' => 'pending',
                ]);
            $payop = new PayOpHelper();
            $invoice = $payop->createInvoice($order, $user, $package);
            //$invoiceData = $payop->getInvoice($invoice->data);
            $invoiceId = $invoice->data;
            //$invoiceData = $payop->getInvoice("aa41d116-8e62-4e5d-831b-b3f3c802d028");
            //$transactionId = $invoiceData->data->transactionIdentifier;
            $order->update([
                'invoice_id' => $invoiceId,
                'data' => $invoice,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
        DB::commit();
        $url = "https://payop.com/en/payment/{$invoice->data}";
        return redirect()->away($url);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function handleAPICallback(Request $request)
    {
		Log::debug("PayOP callback data", $request->all());
        // Validate parameters
        /*$this->validate($request,[
            'transaction.id' => ['required', 'string'],
            'transaction.state' => ['required', 'string'],
            'transaction.order.id' => ['nullable', 'string'],
            'transaction.error.message' => ['nullable', 'string'],
            'invoice.id' => ['required', 'string'],
            'invoice.status' => ['required', 'string'],
            'invoice.txid' => ['required', 'string'],
        ]);*/

        $invoiceId = $request->offsetGet('invoice.id');
        $transactionId = $request->offsetGet('transaction.id');

        $order = PayOpInvoices::query()
            ->where('invoice_id', $invoiceId)
            ->first();

        if (!$order) {
            Log::debug("PayOP callback error", ['error' => 'PayOP order not found']);
            return response()->json(['error' => "order doesn't exist"], 404);
            //return view('theme::frontend.account.donations.payop.index', ['error' => "order doesn't exist"]);
        }

        $payload = $request->offsetGet('invoice.metadata.payload');

        // Validate payload
        if ($order->payload !== $payload) {
            Log::debug("PayOP callback error", ['error' => 'invalid payload']);
            //return response()->json(['error' => "invalid payload"], 404);
        }

        // Get payop transaction and status
        try {
            $payop = new PayOpHelper();
            // Get transaction data
            $transaction = $payop->getTransaction($transactionId);
            $transactionData = collect($transaction->data);
            // Check transaction status
            $transactionStatus = $payop->getTransactionStatus($transactionData->get('state'));
        } catch (Exception $e) {
            Log::debug("PayOP callback error", ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }

        // Return error if hash is invalid
        /* if (!$payop->validateHash($order, $transactionData)) {
             Log::debug("PayOP callback error", ['error' => "Invalid transaction hash"]);
             return response()->json(['error' => "Invalid transaction hash"], 400);
         }*/

        // Get order user
        $user = $order->user;

        // Return error if there is no user found
        if (!$user) {
            Log::debug("PayOP callback error", ['error' => 'invalid user!']);
            return response()->json(['error' => 'invalid user!'], 404);
        }

        // Return error if the transaction status is paid in our end and silk been added before
        if ($order->state === 'paid') {
            Log::debug("PayOP callback error", ['message' => "order is already paid and added to user, nothing new was added!"]);
            return response()->json(['message' => "order is already paid and added to user, nothing new was added!"], 400);
        }

        DB::beginTransaction();
        try {
            // Add silk and edit data if status is paid
            if ($transactionStatus === 'paid') {

                $order->update([
                    'state' => 'paid',
                ]);

                AphChangedSilk::create([
                    'JID' => $user->jid,
                    'RemainedSilk' => $order->silk,
                    'ChangedSilk' => 0,
                    'SilkType' => 3,
                    'SellingTypeID' => 2,
                    'ChangeDate' => now(),
                    'AvailableDate' => now()->addYears(1),
                    'AvailableStatus' => 'Y',
                ]);

            } else {
                $order->update([
                    'state' => $transactionStatus,
                ]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::debug("PayOP callback error", ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 422);
        }
        DB::commit();
        return response()->json(['success' => 'Silk has been added successfully!']);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function handleSuccessCallback(Request $request)
    {
        $method = $request->getMethod();
        Log::debug("PayOP $method request", $request->all());

        // Validate parameters
        $request->validate([
            'invoiceId' => ['nullable', 'string'],
            'txid' => ['nullable', 'string'],
        ]);

        $invoiceId = $request->get('invoiceId');
        $transactionId = $request->get('txid');

        return view('profile.donations.payop.success', ['success' => "Your transaction has been processed successfully"]);
        /*$order = PayOpInvoices::query()
            ->where('invoice_id', $transactionId)
            ->first();

        if (!$order) {
            Log::debug('order not found');
            return view('theme::frontend.account.donations.payop.success', ['error' => "order doesn't exist"]);
        }

        // Return error if the transaction status is paid in our end and silk been added before
        if ($order->state === 'paid') {
            return view('theme::frontend.account.donations.payop.success', ['message' => "order is already paid and added to user, nothing new was added!"]);
        }
        // Get payop transaction and status
        $payop = new PayOpHelper();
        try {
            // Get transaction data
            $transaction = $payop->getTransaction($transactionId);
            $transactionData = collect($transaction->data);
            Log::debug('order not found', $transactionData->toArray());
            // Check transaction status
            $transactionStatus = $payop->getTransactionStatus($transactionData->get('state'));
        } catch (Exception $e) {
            return view('theme::frontend.account.donations.payop.success', ['error' => $e->getMessage()]);
        }

        // Return error if hash is invalid
        if (!$payop->validateHash($order, $transactionData)) {
            return view('theme::frontend.account.donations.payop.success', ['error' => "Invalid transaction hash"]);
        }

        DB::beginTransaction();
        try {
            // Get order user
            $user = $order->user;

            // Return error if there is no user found
            if (!$user) {
                return view('theme::frontend.account.donations.payop.success', ['error' => 'invalid user!']);
            }

            // Add silk and edit data if status is paid
            if ($transactionStatus === 'paid') {
                $currentSilk = $user->getSkSilk->silk_own;
                $user->getSkSilk
                    ->increment('silk_own', $order->silk);

                $order->update([
                    'state' => 'paid',
                ]);

                SkSilkBuyList::query()
                    ->create([
                        'UserJID' => $user->jid,
                        'Silk_Type' => SkSilkBuyList::SILKTYPEWEB,
                        'Silk_Reason' => SkSilkBuyList::SILKREASONWEB,
                        'Silk_Offset' => $currentSilk,
                        'Silk_Remain' => $currentSilk + $order->silk,
                        'ID' => $user->jid,
                        'BuyQuantity' => (int)$order->silk,
                        'OrderNumber' => $order->invoice_id,
                        'AuthDate' => Carbon::now()->format('Y-m-d H:i:s'),
                        'SlipPaper' => 'Paymob: #' . $order->id,
                        'IP' => $request->ip(),
                        'RegDate' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
            } else {
                $order->update([
                    'state' => $transactionStatus,
                ]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return view('theme::frontend.account.donations.payop.success', ['error' => $e->getMessage()]);
        }
        DB::commit();
        return view('theme::frontend.account.donations.payop.success', ['success' => "Your donation has been completed and silk has been added"]);*/
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function handleErrorCallback(Request $request)
    {
        $method = $request->getMethod();
        Log::debug("PayOP $method error request", $request->all());

        // Validate parameters
        $request->validate([
            'invoiceId' => ['nullable', 'string'],
            'txid' => ['nullable', 'string'],
        ]);

        $invoiceId = $request->get('invoiceId');
        $transactionId = $request->get('txid');

        //if (!$invoiceId) {
            return view('profile.donations.payop.error', ['error' => "Something went wrong."]);
        //}

        /*$order = PayOpInvoices::query()
            ->where('invoice_id', $invoiceId)
            ->first();

        if (!$order) {
            Log::debug('order not found');
            return view('theme::frontend.account.donations.payop.error', ['error' => "order doesn't exist"]);
        }

        // Get payop transaction and status
        $payop = new PayOpHelper();
        try {
            // Get transaction data
            $invoice = $payop->getInvoice($invoiceId);
            $invoiceData = collect($invoice->data);
            Log::debug('order not found', $invoiceData->toArray());
            // Check transaction status
            //$transactionStatus = $payop->getTransactionStatus($transactionData->get('state'));
        } catch (Exception $e) {
            return view('theme::frontend.account.donations.payop.error', ['error' => $e->getMessage()]);
        }

        return view('theme::frontend.account.donations.payop.error', ['error' => $invoiceData->get('error')]);*/
    }
}
