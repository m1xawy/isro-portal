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
            'username' => ['required', 'regex:/^[A-Za-z0-9]*$/', 'min:6', 'max:30', 'unique:'.User::class, 'unique:'.MuUser::class.',UserID', 'unique:'.TbUser::class.',StrUserID'],
            'email' => ['required', 'string', 'email', 'max:70', 'unique:'.MuEmail::class.',EmailAddr'],
            'password' => ['required', 'confirmed', 'min:6', 'max:32'],
        ]);

        /*
         * TODO: The code want be more clean.
         * Can't find the best way for getting Binary IP
         * Also about CountryCode it needs hard code
         * */

        $userBinIP = ($request->ip() == "::1") ? ip2long('127.0.0.1') : ip2long($request->ip()); //Fixing local registration

        $returnCode = collect(DB::select("
            Declare @ReturnValue Int
            Declare @ARCode SmallInt
            Declare @JID Int;
            SET NOCOUNT ON;

            Exec @ReturnValue = [GB_JoymaxPortal].[dbo].[A_RegisterNewUser]
                '".$request->username."',
                '".md5($request->password)."',
                'M',
                '".now()->subYears(16)."',
                '".$request->username."',
                '".$request->username."',
                '".$request->email."',
                ".$userBinIP.",
                'J".$request->username."',
                'JOYMAX',
                @ARCode Output,
                @JID Output;

            Select
                @ReturnValue AS 'ErrorCode',
                @ARCode AS 'ARCode',
                @JID AS 'JID'
            "
        ))->first();

        if($returnCode->ErrorCode != 0) {
            return back()->withErrors(['username' => ["An error [".strtoupper($returnCode->ErrorCode)."] occured."]]);
        }

        $portalJID = $returnCode->JID;

        if(setting('register_confirmation_enable', 0) == 1) {
            MuhAlteredInfo::where('JID',$portalJID)->update(['EmailReceptionStatus'=>'N', 'EmailCertificationStatus'=>'N']);

        } else {
            MuhAlteredInfo::where('JID',$portalJID)->update(['EmailReceptionStatus'=>'Y', 'EmailCertificationStatus'=>'Y']);
        }

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

        MuVIPInfo::create([
            'JID' => $portalJID,
            'VIPUserType' => 2,
            'VIPLv' => 1,
            'UpdateDate' => now(),
            'ExpireDate' => now()->addMonths(1),
        ]);

        AphChangedSilk::create([
            'JID' => 1, // Portal JID
            'RemainedSilk' => 0, // Silk Number
            'ChangedSilk' => 0,
            'SilkType' => 3, // 1 = Normal Silk | 3 = Premium Silk
            'SellingTypeID' => 2,
            'ChangeDate' => now(),
            'AvailableDate' => now()->addYears(1),
            'AvailableStatus' => 'Y',
        ]);

        $user = User::create([
            'jid' => $portalJID,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect('/profile');
    }
}
