<?php

namespace App\Http\Controllers\Donate;

use App\Models\Donate\DonationMethods;
use App\Models\Donate\DonationStripes;
use App\Models\SRO\Portal\AphChangedSilk;
use App\Models\Donate\PaypalInvoices;
use App\Models\Donate\StripeInvoices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;

class DonationsStripeController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function buy($id)
    {
        $stripe = DonationStripes::select(['id', 'price', 'name', 'silk'])
            ->findOrFail($id);

        $method = DonationMethods::select('currency')
            ->where('method', '=', 'stripe')
            ->where('active', '=', '1')
            ->firstOrFail();

        if (!config('stripe.public-key') || !config('stripe.secret-key')) {
            return back()->with('error', __('donations.notification.error.missing-keys'));
        }

        return view('profile.donations.stripe.buy', [
            'method' => $method,
            'stripe' => $stripe
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function buyPost(Request $request, $id)
    {
        $this->setApi();
        $stripe = DonationStripes::select(['id', 'price', 'name', 'silk', 'description'])
            ->findOrFail($id);

        $method = DonationMethods::select('currency')
            ->where('method', '=', 'stripe')
            ->where('active', '=', '1')
            ->firstOrFail();

        $stripeMethods = config('stripe.methods', false);
        if (!$stripeMethods) {
            return back()->with('error', __('donations.notification.error.missing-keys'));
        }

        $stripeMethods = explode(',', $stripeMethods);

        $response = array(
            'status' => 0,
            'error' => array(
                'message' => 'Invalid Request!'
            )
        );
        if ($request->getMethod() === 'POST') {
            $input = json_encode($request->all());
            $request = json_decode($input);
        }
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            return response()
                ->json($response);
        }
        if (!empty($request->checkoutSession)) {
            try {
                $session = \Stripe\Checkout\Session::create([
                    'customer_email' => \Auth::user()->email,
                    'customer_creation' => 'always',
                    'payment_method_types' => [$stripeMethods],
                    'payment_intent_data' => ['description' => $stripe->description],
                    'line_items' => [[
                        'price_data' => [
                            'product_data' => [
                                'name' => $stripe->name,
                                'description' => $stripe->description,
                                'metadata' => [
                                    'pro_id' => $stripe->id
                                ]
                            ],
                            'unit_amount' => round($stripe->price * 100, 2),
                            'currency' => $method->currency,
                        ],
                        'quantity' => 1,
                    ]],
                    'mode' => 'payment',

                    'success_url' => route('donate-stripe-success') . '?session_id={CHECKOUT_SESSION_ID}' . '&sid=' . $id,
                    'cancel_url' => route('donate-stripe-error'),
                ]);
            } catch (\Exception $e) {
                $api_error = $e->getMessage();
            }

            if (empty($api_error) && $session) {
                $response = array(
                    'status' => 1,
                    'message' => 'Checkout Session created successfully!',
                    'sessionId' => $session['id']
                );
            } else {
                $response = array(
                    'status' => 0,
                    'error' => array(
                        'message' => 'Checkout Session creation failed! ' . $api_error
                    )
                );
            }
        }
        return response()
            ->json($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Throwable
     */
    public function success(Request $request)
    {
        $intent = false;
        $state = false;
        $statusMsg = false;
        $sid = request()->has('session_id');
        $stripeId = request()->has('sid');

        Log::debug($request);

        if ($sid && $stripeId) {
            $session_id = $request->query('session_id');
            $stripeId = $request->query('sid');

            $stripe = DonationStripes::select(['id', 'price', 'name', 'silk', 'description'])->findOrFail($stripeId);

            $stripeInvoice = StripeInvoices::where('payment_reference', '=', $session_id)->first();
            if ($stripeInvoice) {
                $state = true;
                $statusMsg = 'Your Payment has been Successful!';
            } else {
                $this->setApi();

                try {
                    $checkout_session = \Stripe\Checkout\Session::retrieve($session_id);

                    Log::debug($checkout_session);

                } catch (\Exception $e) {
                    $api_error = $e->getMessage();
                }

                if (empty($api_error) && $checkout_session) {
                    // Retrieve the details of a PaymentIntent
                    try {
                        $intent = \Stripe\PaymentIntent::retrieve($checkout_session->payment_intent);
                    } catch (\Stripe\Exception\ApiErrorException $e) {
                        $api_error = $e->getMessage();
                    }

                    // Retrieves the details of customer
                    /*
                    try {
                        // Create the PaymentIntent
                        $customer = \Stripe\Customer::retrieve($checkout_session->customer);
                    } catch (\Stripe\Exception\ApiErrorException $e) {
                        $api_error = $e->getMessage();
                    }
                    */

                    // Check whether the charge is successful
                    if ($intent && $intent->status === 'succeeded') {
                        // Transaction details
                        $paidAmount = $intent->amount;
                        $paidAmount /= 100;
                        $paymentStatus = $intent->status;

                        $invoice = StripeInvoices::create([
                            'user_id' => \Auth::id(),
                            'payment_reference' => $session_id,
                            'payment_id' => $intent->id,
                            'name' => $stripe->name,
                            'price' => $paidAmount,
                            'silk' => $stripe->silk,
                            'state' => PaypalInvoices::STATE_PAID,
                        ]);

                        if ($paymentStatus === 'succeeded') {
                            $state = true;
                            $statusMsg = 'Your Payment has been Successful!';

                            $this->addSilk($invoice, $request->ip());
                        } else {
                            $state = false;
                            $statusMsg = 'Your Payment has failed!';
                        }
                    }
                }
            }
        }
        return view('profile.donations.stripe.success', [
            'status' => $statusMsg,
            'state' => $state
        ]);
    }

    /**
     * @param StripeInvoices $invoice
     * @param $ip
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    private function addSilk(StripeInvoices $invoice, $ip)
    {
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

            $invoice->state = StripeInvoices::STATE_PAID;
            $invoice->save();

            DB::commit();
            DB::connection('account')->commit();

        } catch (\Exception $e) {
            DB::rollback();
            DB::connection('account')->rollback();
            return redirect()->route('donate-stripe-error')
                ->with('error', $e->getMessage());
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function error()
    {
        return view('profile.donations.stripe.error');
    }


    private function setApi()
    {
        Stripe::setApiKey(config('stripe.secret-key'));
    }
}
