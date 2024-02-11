<?php

namespace App\Http\Controllers\Donate;

use App\Models\Donate\DonationMaxiCard;
use App\Models\Donate\DonationMaxiCardLog;
use App\Models\Donate\DonationMethods;
use App\Helpers\Donate\MaxiCard\MaxiCardApiHelper;
use App\Http\Controllers\Controller;
use App\Models\SRO\Portal\AphChangedSilk;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DonationsMaxiCardController extends Controller
{
    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function buy()
    {
        //check whether method is enabled or not
        $method_enabled = DonationMethods::where('method', 'maxicard')
            ->first();

        //return error if method not found or not active
        if (!$method_enabled || !$method_enabled->active) {
            return redirect()->route('donations-index')->with(['error' => __('donations.maxicard.disabled')]);
        }

        return view('profile.donations.maxicard.buy');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function store(Request $request): RedirectResponse
    {
        //check whether method is enabled or not
        $method_enabled = DonationMethods::where('method', 'maxicard')
            ->first();

        //return error if method not found or not active
        if (!$method_enabled || !$method_enabled->active) {
            return redirect()->route('donations-index')->with(['error' => __('donations.maxicard.disabled')]);
        }

        //validate data
        $request->validate([
            'code' => ['required'],
            'password' => ['required'],
        ]);
        $user = Auth::user();
        $response = MaxiCardApiHelper::sendMaxiCardPostRequest($request->get('code'), $request->get('password'));

        //Log::info($request);

        if (trim($response->params->durum) === 'ok' && intval(trim($response->params->siparis_no)) > 0) {

            //order number
            $order_number = intval(trim($response->params->siparis_no));

            //The amount of Epin code in Decimal
            $amount = trim($response->params->tutar);
            $amount = preg_replace('/[^0-9]/', '', $amount);
            $amount = intval($amount);

            //Commission
            $commission = trim($response->params->komisyon);
            $commission = preg_replace('/[^0-9\.]/', '', $commission);

            if (!$amount || $amount <= 0) {
                //return error
                return redirect()->back()->with(['error' => 'This epin is invalid, Please try a valid one']);
            }
            //get epin amount
            $epin = DonationMaxiCard::where('price', $amount)
                ->first();

            //set silk amount
            if ($epin) {
                $silk = $epin->silk;
            } else {
                $silk = $amount;
            }

            DB::beginTransaction();
            try {
                //add silk to user
                AphChangedSilk::create([
                    'JID' => $user->jid,
                    'RemainedSilk' => $silk,
                    'ChangedSilk' => 0,
                    'SilkType' => 3,
                    'SellingTypeID' => 2,
                    'ChangeDate' => now(),
                    'AvailableDate' => now()->addYears(1),
                    'AvailableStatus' => 'Y',
                ]);

                //add log
                DonationMaxiCardLog::create([
                    'user_id' => $user->id,
                    'order_number' => $order_number,
                    'epin_code' => $request->get('code'),
                    'epin_password' => $request->get('password'),
                    'epin_amount_id' => $epin ? $epin->id : null,
                    'epin_amount' => $silk,
                    'commission' => $commission
                ]);
            } catch (Exception $e) {
                DB::rollBack();
                return redirect()->back()->with(['error' => 'Something went wrong, Please try again later.']);
            }
            DB::commit();

            return redirect()->back()->with(['success' => "You've successfully purchased {$silk} and your current balance is {$user->getJCash()->PremiumSilk}"]);
        } else if (trim($response->params->durum) === 'bayi_hata') {

            //return error with wrong api if the data is wrong in env
            return redirect()->back()->with(['error' => 'Wrong API Key or API Password.']);
        }

        return redirect()->back()->with(['error' => 'This epin is invalid, Please try a valid one']);
    }
}
