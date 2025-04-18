<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\SRO\Portal\AphChangedSilk;
use App\Models\SRO\Portal\MuEmail;
use App\Models\SRO\Portal\MuhAlteredInfo;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        return view('profile.index', [
            'user' => $request->user(),
        ]);
    }

    public function donate(Request $request): View
    {
        return view('profile.donate', [
            'user' => $request->user(),
        ]);
    }

    public function donate_history(Request $request): View
    {
        $data = AphChangedSilk::getDonateHistory($request->user()->jid);

        return view('profile.donate-history', [
            'user' => $request->user(),
            'data' => $data,
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

        DB::beginTransaction();
        try {
            MuEmail::where('JID', $request->user()->jid)->update(['EmailAddr' => $request->user()->email]);
            if(config('settings.general.options.register_confirmation')) {
                MuhAlteredInfo::where('JID', $request->user()->jid)->update(['EmailAddr' => $request->user()->email, 'EmailReceptionStatus'=>'N', 'EmailCertificationStatus'=>'N']);
            } else {
                MuhAlteredInfo::where('JID', $request->user()->jid)->update(['EmailAddr' => $request->user()->email, 'EmailReceptionStatus'=>'Y', 'EmailCertificationStatus'=>'Y']);
            }

        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors(['email' => ["Something went wrong, Please try again later."]]);
        }
        DB::commit();

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
