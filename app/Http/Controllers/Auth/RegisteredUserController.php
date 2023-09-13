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
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

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
            'username' => ['required', 'string', 'min:6', 'max:32', 'unique:'.User::class, 'unique:'.MuUser::class.',UserID', 'unique:'.TbUser::class.',StrUserID'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.MuEmail::class.',EmailAddr'],
            'password' => ['required', 'confirmed', 'min:6', 'max:32'],
        ]);

        /*
         * TODO: The code want be more clean.
         * Can't find the best way for getting Binary IP
         * Also about CountryCode it needs hard code
         * */

        //dd(ip2long($request->ip()));

        //$userIP = ($request->ip() == "::1") ? '127.0.0.1' : $request->ip();
        //$userBinIP = collect(DB::select("SELECT [GB_JoymaxPortal].[dbo].[F_MakeIPStringToIPBinary]('".$userIP."') AS UserBinIP"))->first()->UserBinIP;
        //$countryCode = collect(DB::select("SELECT [GB_JoymaxPortal].[dbo].[F_GetCountryCodeByIPString]('".$userIP."') AS CountryCode"))->first()->CountryCode;

        $mu_user = MuUser::create([
            'UserID' => $request->username,
            'UserPwd' => md5($request->password),
            'Gender' => 'M',
            'Birthday' => now(),
            'NickName' => $request->username,
            'CountryCode' => 'EG',
            'AbusingCount' => 0,
        ]);

        TbUser::create([
            'PortalJID' => $mu_user->JID,
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

        MuhAlteredInfo::create([
            'JID' => $mu_user->JID,
            'AlterationDate' => now(),
            'LastName' => $request->username,
            'FirstName' => $request->username,
            'EmailAddr' => $request->email,
            'EmailReceptionStatus' => 'Y',
            'EmailCertificationStatus' => 'Y',
            'UserIP' => ip2long($request->ip()),
            'CountryCode' => 'EG',
            'NickName' => $request->username,
            'ATypeCode' => 1,
            'CountryCodeChangingStatus' => 'N',
        ]);

        AphChangedSilk::create([
            'JID' => $mu_user->JID,
            'RemainedSilk' => 0,
            'ChangedSilk' => 0,
            'SilkType' => 3,
            'SellingTypeID' => 2,
            'ChangeDate' => now(),
            'AvailableDate' => now()->subYear(10),
            'AvailableStatus' => 'Y',
        ]);

        MuEmail::create([
            'JID' => $mu_user->JID,
            'EmailAddr' => $request->email,
        ]);

        AuhAgreedService::create([
            'JID' => $mu_user->JID,
            'ServiceCode' => 2,
            'StartDate' => now(),
            'EndDate' => now()->subYear(10),
            'UserIP' => ip2long($request->ip()),
        ]);

        MuJoiningInfo::create([
            'JID' => $mu_user->JID,
            'UserIP' => ip2long($request->ip()),
            'JoiningDate' => now(),
            'CountryCode' => 'EG',
            'JoiningPath' => 'JOYMAX',
        ]);

        $user = User::create([
            'jid' => $mu_user->JID,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
