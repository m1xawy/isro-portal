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

        $returnCode = collect(DB::select("
            Declare @ReturnValue Int
            Declare @ARCode SmallInt
            Declare @JID Int;
            SET NOCOUNT ON;

            Exec @ReturnValue = [GB_JoymaxPortal].[dbo].[A_RegisterNewUser]
                '".$request->username."',
                '".md5($request->password)."',
                'M',
                '2000-12-12',
                'Han',
                'Doc',
                '".$request->email."',
                0x00000000,
                'J".$request->username."',
                'J',
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
            'ExpireDate' => now()->addMonth(1),
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
