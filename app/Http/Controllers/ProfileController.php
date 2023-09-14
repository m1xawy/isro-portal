<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\SRO\Portal\MuVIPInfo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        $VIPInfo = [
            // VIP minimum level to show the VIP category
            "level_access"=>4, //joymax default
            // VIP level names will show in webmall
            "level"=>[
                0=>"Normal",
                1=>"Iron",
                2=>"Bronze",
                3=>"Silver",
                4=>"Gold",
                5=>"Platinum",
                6=>"VIP"
            ],
            // VIP Types
            "type"=>[
                0=>"General",
                1=>"VIP",
                2=>"New",
                3=>"Returne",
                4=>"Free"
            ]
        ];

        $GetVIPInfo = MuVIPInfo::where('JID', $request->user()->jid)->first();

        $GetJCash = DB::select("
            Declare @PremiumSilk Int
            ,@Silk Int
            ,@VipLevel Int
            ,@UsageMonth Int
            ,@Usage3Month Int;

            EXEC [GB_JoymaxPortal].[dbo].[B_GetJCash] ".$request->user()->jid."
            ,@PremiumSilk Output
            ,@Silk Output
            ,@VipLevel Output
            ,@UsageMonth Output
            ,@Usage3Month Output;

            Select @PremiumSilk as 'PremiumSilk'
            ,@Silk as 'Silk'
            ,@VipLevel as 'VIP'
            ,@UsageMonth as 'UsageMonth'
            ,@Usage3Month as 'Usage3Month'
            "
        );

        return view('profile.index', [
            'user' => $request->user(),
            'GetJCash' => $GetJCash,
            'GetVIPInfo' => $GetVIPInfo,
            'VIPInfo' => $VIPInfo,
        ]);
    }

    public function donate(Request $request): View
    {
        return view('profile.donate', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
