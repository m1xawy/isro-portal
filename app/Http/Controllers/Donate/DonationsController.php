<?php

namespace App\Http\Controllers\Donate;

use App\Models\Donate\DonationMaxiCard;
use App\Models\Donate\DonationMethods;
use App\Models\Donate\DonationPaypals;
use App\Http\Controllers\Controller;
use App\Models\Donate\PaypalInvoices;
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
            return redirect()->route('donations-index')->with(['error' => 'This method is currently disabled.']);
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
