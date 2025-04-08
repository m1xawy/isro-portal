<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SRO\Account\TbUser;
use App\Models\SRO\Portal\AphChangedSilk;
use App\Models\SRO\Portal\AuhAgreedService;
use App\Models\SRO\Portal\MuEmail;
use App\Models\SRO\Portal\MuhAlteredInfo;
use App\Models\SRO\Portal\MuJoiningInfo;
use App\Models\SRO\Portal\MuUser;
use App\Models\SRO\Portal\MuVIPInfo;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => ['required', 'regex:/^[A-Za-z0-9]*$/', 'min:6', 'max:16', 'unique:'.User::class, 'unique:'.MuUser::class.',UserID', 'unique:'.TbUser::class.',StrUserID'],
            'email' => ['required', 'string', 'email', 'max:70', 'unique:'.MuEmail::class.',EmailAddr'],
            'password' => ['required', 'confirmed', 'min:6', 'max:32'],
            'g-recaptcha-response' => [
                Rule::requiredIf(function () {
                    return setting('register_reraptcha_enable');
                }),
                'captcha'
            ],
        ]);

        /*
         * TODO: The code want be more clean.
         * Can't find the best way for getting Binary IP
         * Also about CountryCode it needs hard code
         * */

        DB::beginTransaction();
        try {

            $portalUser = MuUser::create([
                'UserID' => $request->username,
                'UserPwd' => md5($request->password),
                'Gender' => 'M',
                'Birthday' => now(),
                'NickName' => $request->username,
                'CountryCode' => 'EG',
                'AbusingCount' => 0,
            ]);

            $portalJID = $portalUser->JID;
            $userBinIP = ($request->ip() == "::1") ? ip2long('127.0.0.1') : ip2long($request->ip()); //Fixing local registration

            MuEmail::create([
                'JID' => $portalJID,
                'EmailAddr' => $request->email,
            ]);

            MuhAlteredInfo::create([
                'JID' => $portalJID,
                'AlterationDate' => now(),
                'LastName' => $request->username,
                'FirstName' => $request->username,
                'EmailAddr' => $request->email,
                'EmailReceptionStatus' => 'N',
                'EmailCertificationStatus' => 'N',
                'UserIP' => $userBinIP,
                'CountryCode' => 'EG',
                'NickName' => $request->username,
                'ATypeCode' => 1,
                'CountryCodeChangingStatus' => 'N',
            ]);

            if(setting('register_confirmation_enable', 0) == 1) {
                MuhAlteredInfo::where('JID',$portalJID)->update(['EmailReceptionStatus'=>'N', 'EmailCertificationStatus'=>'N']);

            } else {
                MuhAlteredInfo::where('JID',$portalJID)->update(['EmailReceptionStatus'=>'Y', 'EmailCertificationStatus'=>'Y']);
            }

            AuhAgreedService::create([
                'JID' => $portalJID,
                'ServiceCode' => 2,
                'StartDate' => now(),
                'EndDate' => '9999-12-31 00:00:00',
                'UserIP' => $userBinIP
            ]);

            MuJoiningInfo::create([
                'JID' => $portalJID,
                'UserIP' => $userBinIP,
                'JoiningDate' => now(),
                'CountryCode' => 'EG',
                'JoiningPath' => 'JOYMAX'
            ]);

            MuVIPInfo::create([
                'JID' => $portalJID,
                'VIPUserType' => 2,
                'VIPLv' => 1,
                'UpdateDate' => now(),
                'ExpireDate' => now()->addMonths(1),
            ]);

            AphChangedSilk::create([
                'JID' => $portalJID,
                'RemainedSilk' => 0,
                'ChangedSilk' => 0,
                'SilkType' => 3,
                'SellingTypeID' => 2,
                'ChangeDate' => now(),
                'AvailableDate' => now()->addYears(1),
                'AvailableStatus' => 'Y',
            ]);

            TbUser::create([
                'PortalJID' => $portalJID,
                'StrUserID' => $request->username,
                'ServiceCompany' => 11,
                'password' => md5($request->password),
                'Active' => 1,
                'UserIP' => $request->ip(),
                'CountryCode' => 'EG',
                'VisitDate' => now(),
                'RegDate' => now(),
                'sec_primary' => 3,
                'sec_content' => 3,
                'sec_grade' => 0,
            ]);

            $user = User::create([
                'jid' => $portalJID,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors(['username' => ["Something went wrong, Please try again later."]]);
        }
        DB::commit();

        event(new Registered($user));

        Auth::login($user);

        return redirect('/profile');
    }
}
