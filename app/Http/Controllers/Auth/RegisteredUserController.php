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
                    return config('global.captcha.enable');
                }),
                'captcha'
            ],
        ]);

        DB::beginTransaction();
        try {

            //Fixing local registration
            $userBinIP = ($request->ip() == "::1") ? ip2long('127.0.0.1') : ip2long($request->ip());

            $portalUser = MuUser::setPortalAccount($request->username, $request->password);
            MuEmail::setEmail($portalUser->JID, $request->email);
            MuhAlteredInfo::setAlteredInfo($portalUser->JID, $request->username, $request->email, $userBinIP);
            AuhAgreedService::setAgreedService($portalUser->JID, $userBinIP);
            MuJoiningInfo::setJoiningInfo($portalUser->JID, $userBinIP);
            MuVIPInfo::setVIPInfo($portalUser->JID);

            $free_silk = config('global.general.options.free_silk');
            $free_premium_silk = config('global.general.options.free_premium_silk');
            //type 1 = silk, type 3 = premium silk
            AphChangedSilk::setChangedSilk($portalUser->JID, 1, $free_silk);
            AphChangedSilk::setChangedSilk($portalUser->JID, 3, $free_premium_silk);
            TbUser::setGameAccount($portalUser->JID, $request->username, $request->password, $request->ip());

            $user = User::create([
                'jid' => $portalUser->JID,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors(['username' => [$e->getMessage()]]);
        }
        DB::commit();

        event(new Registered($user));

        Auth::login($user);

        return redirect('/profile');
    }
}
