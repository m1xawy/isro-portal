<?php

namespace App\Http\Controllers\Donate;

use App\Models\Donate\CoinbaseInvoices;
use App\Models\Donate\DonationCoinbase;
use App\Helpers\Donate\Coinbase\CoinbaseHelper;
use App\Http\Controllers\Controller;
use App\Models\SRO\Portal\AphChangedSilk;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonationsCoinbaseController extends Controller
{

    /**
     * @return RedirectResponse
     * @throws Exception
     */
    public function buy(int $id, Request $request)
    {
        $price = DonationCoinbase::query()
            ->where('id', $id)
            ->firstOrFail();

        $user = $request->user();
        DB::beginTransaction();
        try {

            $data = [
                'amount' => $price->price,
                'name' => $price->name,
                'description' => "$price->description for user #$user->id, Please notice that this transaction is nonrefundable",
            ];

            $coinbase = new CoinbaseHelper();
            $invoice = $coinbase->createInvoice($data, $user);
            CoinbaseInvoices::query()
                ->create([
                    'user_id' => $user->id,
                    'invoice_id' => $invoice->code,
                    'name' => $price->name,
                    'price' => $price->price,
                    'silk' => $price->silk,
                    'state' => 'pending',
                    'data' => $invoice,
                ]);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
        DB::commit();
        return redirect()->away($invoice->hosted_url);
    }

    /**
     * @param Request $request
     * @return JsonResponse|string
     * @throws Exception
     */
    public function handleCallback(Request $request)
    {
        //\Log::debug('data', $request->all());
        $this->validate($request, [
            'event' => ['required', 'array'],
            'event.type' => ['required'],
            'event.data' => ['required', 'array'],
            'event.data.invoice.code' => ['nullable'],
            'event.data.code' => ['nullable'],
        ]);
		$types = [
            'charge:created',
            'charge:delayed',
            'charge:pending',
            'charge:resolved',
            'invoice:created',
            'invoice:payment_pending',
            'invoice:unresolved',
            'invoice:viewed',
            'invoice:voided',
        ];

        if (in_array($request->offsetGet('event.type'), $types)) {
            return response()->json('OK');
        }
        $order = CoinbaseInvoices::query()
            ->where('invoice_id', $request->offsetGet('event.data.invoice.code'))
            ->first();

        if (!$order) {
            //\Log::debug('order not found');
            return response()->json(['error' => "order doesn't exist"], 422);
        }


        if ($order->state === 'declined') {
            return response()->json(['error' => "order has been declined!"], 422);
        }
        $hash = hash_hmac('sha256', $request->getContent(), config('coinbase.webhook-signature'));

        if ($request->header('X-CC-Webhook-Signature') !== $hash) {
            return response()->json(['error' => "invalid hash!"], 422);
        }
        DB::beginTransaction();
        try {
            $user = $order->user;

            if (!$user) {
                return response()->json(['error' => 'invalid user!'], 422);
            }
            if ($request->offsetGet('event.type') === 'charge:confirmed') {
                if ($order->state === 'paid') {
                    return response()->json(['message' => "order has already been paid and added to user!"]);
                }
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
            } else if ($request->offsetGet('event.data') === 'charge:failed') {
                $order->update([
                    'state' => 'declined',
                ]);
            } else {
                $order->update([
                    'state' => 'pending',
                ]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 422);
        }
        DB::commit();
        //return response()->json("Silk has been added successfully to user #{$user->id} and JID #{$user->jid}")->send();
        return 'OK';
    }
}
