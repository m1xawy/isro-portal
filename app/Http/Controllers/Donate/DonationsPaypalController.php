<?php

namespace App\Http\Controllers\Donate;

use App\Models\Donate\DonationMethods;
use App\Models\Donate\DonationPaypals;
use App\Http\Controllers\Controller;
use App\Models\SRO\Portal\AphChangedSilk;
use App\Models\Donate\PaypalInvoices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Omnipay\Omnipay;

class DonationsPaypalController extends Controller
{
    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function buy(Request $request, $id)
    {
        $paypal = DonationPaypals::select(['id', 'price', 'name', 'silk'])
            ->findOrFail($id);
        $method = DonationMethods::select('currency')
            ->where('method', '=', 'paypal')
            ->where('active', '=', '1')
            ->firstOrFail();

        $invoice = PaypalInvoices::create([
            'user_id' => \Auth::id(),
            'payment_id' => '',
            'name' => $paypal->name,
            'price' => $paypal->price,
            'silk' => $paypal->silk,
            'state' => PaypalInvoices::STATE_PENDING,
        ]);

        try {
            $response = $this->gateway()->purchase([
                'amount' => $this->formatAmount($paypal->price),
                'currency' => $method->currency,
                'description' => $paypal->name,
                'notifyUrl' => route('donate-paypal-notify'),
                'cancelUrl' => route('donate-paypal-error', ['id' => $invoice->id]),
                'returnUrl' => route('donate-paypal-complete'),
            ])->send();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        if ($response->isRedirect()) {
            $invoice->payment_id = $response->getTransactionReference();
            $invoice->save();
            $response->redirect();
        }
        return redirect()->back()->with([
            'message' => $response->getMessage(),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function complete(Request $request)
    {
        $response = $this->gateway()->completePurchase(
            [
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ]
        )->send();

        $data = $response->getData();

        //Log::debug($data);

        $invoice = PaypalInvoices::where('payment_id', $data['id'])->first();

        if ($invoice->state === PaypalInvoices::STATE_PAID) {
            return redirect()->route('donate-paypal-invoice-closed');
        }

        if ($data['state'] === 'approved') {
            DB::beginTransaction();
            DB::connection('account')->beginTransaction();
            try {
                $user = \Auth::user();

                AphChangedSilk::create([
                    'JID' => $user->jid,
                    'RemainedSilk' => $invoice->silk,
                    'ChangedSilk' => 0,
                    'SilkType' => 3,
                    'SellingTypeID' => 2,
                    'ChangeDate' => now(),
                    'AvailableDate' => now()->addYears(1),
                    'AvailableStatus' => 'Y',
                ]);

                $invoice->state = PaypalInvoices::STATE_PAID;
                $invoice->save();

                DB::commit();
                DB::connection('account')->commit();

                return redirect()->route('donate-paypal-success')
                    ->with('successfully', $invoice->silk);
            } catch (\Exception $e) {
                DB::rollback();
                DB::connection('account')->rollback();
                return redirect()->route('donate-paypal-error')
                    ->with('error', $e->getMessage());
            }
        } else {
            return redirect()->route('donate-paypal-error');
        }
    }

    /**
     * @param $amount
     * @return string
     */
    public function formatAmount($amount): string
    {
        return number_format($amount, 2, '.', '');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function success()
    {
        return view('profile.donations.success');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function error($id)
    {
        $invoice = PaypalInvoices::where('id', '=', $id)
            ->where('user_id', '=', \Auth::id())
            ->firstOrFail();

//        $transaction = $this->gateway()->fetchPurchase();
//        $transaction->setTransactionReference($invoice->payment_id);
//        $response = $transaction->send();
//        $data = $response->getData();

        $invoice->state = PaypalInvoices::STATE_CANCELED;
        $invoice->save();

        return view('profile.donations.error');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function invoiceClosed()
    {
        return view('profile.donations.invoiceclosed');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function notify()
    {
        return view('profile.donations.invoiceclosed');
    }

    /**
     * @return \Omnipay\Common\GatewayInterface
     * @throws \Exception
     */
    private function gateway()
    {
        $gateway = Omnipay::create('PayPal_Rest');

        $mode = config('paypal.mode');

        if ($mode === 'live') {
            if (config('paypal.live.clientId') && config('paypal.live.secret')) {
                $gateway->setClientId(config('paypal.live.clientId'));
                $gateway->setSecret(config('paypal.live.secret'));
            } else {
                throw new \Exception(__('donations.notification.error.missing-keys'));
            }
        } else {
            if (config('paypal.sandbox.clientId') && config('paypal.sandbox.secret')) {
                $gateway->setClientId(config('paypal.sandbox.clientId'));
                $gateway->setSecret(config('paypal.sandbox.secret'));
            } else {
                throw new \Exception(__('donations.notification.error.missing-keys'));
            }
            $gateway->setTestMode(true);
        }

        return $gateway;
    }
}
