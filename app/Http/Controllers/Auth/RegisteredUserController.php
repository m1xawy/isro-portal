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
            'username' => ['required', 'string', 'min:6', 'max:32', 'unique:'.User::class, 'unique:'.MuUser::class.',UserID', 'unique:'.TbUser::class.',StrUserID'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.MuEmail::class.',EmailAddr'],
            'password' => ['required', 'confirmed', 'min:6', 'max:32'],
        ]);

        $countryCode = 'ZZ';
        $userIP = ($request->ip() == "::1") ? '127.0.0.1' : $request->ip();
        $lastJIDQuery = ';SELECT TOP 1 JID FROM [GB_JoymaxPortal].[dbo].[MU_User] ORDER BY JID DESC;';

        $returnCode = DB::select("EXEC [SILKROAD_R_ACCOUNT].[dbo].[_Rigid_Register_User]
            '".$request->username."',
            '".md5($request->password)."',
            '".$request->email."',
            '".$countryCode."',
            '".$userIP."'
            ".$lastJIDQuery." "
        );

        MuVIPInfo::create([
            'JID' => $returnCode[0]->JID,
            'VIPUserType' => 2,
            'VIPLv' => 1,
            'UpdateDate' => now(),
            'ExpireDate' => now()->subMonth(1),
        ]);

        $user = User::create([
            'jid' => $returnCode[0]->JID,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
