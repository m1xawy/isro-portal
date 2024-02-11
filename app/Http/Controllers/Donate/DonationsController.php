<?php

namespace App\Http\Controllers\Donate;

use App\Models\Donate\DonationMaxiCard;
use App\Models\Donate\DonationMethods;
use App\Models\Donate\CoinbaseInvoices;
use App\Models\Donate\DonationCoinbase;
use App\Models\Donate\DonationPaypals;
use App\Models\Donate\DonationStripes;
use App\Http\Controllers\Controller;
use App\Models\Donate\PaypalInvoices;
use App\Models\Donate\DonationPayOp;
use App\Models\Donate\PayOpInvoices;
use Illuminate\Http\Request;

class DonationsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $donationMethods = DonationMethods::where('active', '=', 1)->get();
        return view('profile.donate', [
            'donationMethods' => $donationMethods
        ]);
    }

    /**
     * @param null $method
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showMethod(Request $request, $method = null)
    {
        $donationMethod = DonationMethods::where('method', '=', $method)->firstOrFail();

        if (!$donationMethod->active) {
            return redirect()->route('donations-index')->with(['error' => __('donations.paypal.disabled')]);
        }

		if($method === 'egyptian'){
			return view('profile.donations.custom.egyptian');
		}

		if($method === 'international'){
			return view('profile.donations.custom.international');
		}

        if ($method === 'coinbase') {
            $coinbase = DonationCoinbase::query()
                ->get();
            $invoices = CoinbaseInvoices::query()
                ->where('user_id', $request->user()->id)
                ->where('state', 'pending')
                ->get();
            return view('profile.donations.coinbase.index', [
                'method' => $donationMethod,
                'coinbase' => $coinbase,
                'invoices' => $invoices,
            ]);
        }

        if ($method === 'paypal') {
            $paypal = DonationPaypals::all();
            $pendingInvoices = PaypalInvoices::where('user_id', '=', \Auth::id())
                ->where('state', '=', PaypalInvoices::STATE_PENDING)
                ->get();
            return view('profile.donations.paypal', [
                'method' => $donationMethod,
                'paypal' => $paypal,
                'invoices' => $pendingInvoices
            ]);
        }

        if ($method === 'payop') {
            $payop = DonationPayOp::query()
                ->get();
            $pendingInvoices = PayOpInvoices::query()
                ->where('user_id', $request->user()->id)
				->where('state', 'pending')
                ->get();
            return view('profile.donations.payop.index', [
                'method' => $donationMethod,
                'payop' => $payop,
                'invoices' => $pendingInvoices,
            ]);
        }

        if ($method === 'stripe') {
            $stripe = DonationStripes::all();
            return view('profile.donations.stripe.index', [
                'method' => $donationMethod,
                'stripe' => $stripe
            ]);
        }

        if ($method === 'maxicard') {
            $maxicard = DonationMaxiCard::all();
            return view('profile.donations.maxicard.index', [
                'method' => $donationMethod,
                'maxicard' => $maxicard
            ]);
        }
        return back();
    }
}
