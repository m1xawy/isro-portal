<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\SRO\Portal\AphChangedSilk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $donateHistory = cache()->remember('donateHistory'.$request->user()->jid, 600, function() use ($request) {
            return AphChangedSilk::where('JID', $request->user()->jid)->orderBy('ChangeDate', 'DESC')->get();
        });

        return view('profile.donate-history', [
            'user' => $request->user(),
            'donateHistory' => $donateHistory,
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit_password(Request $request): View
    {
        return view('profile.edit-password', [
            'user' => $request->user(),
        ]);
    }

    public function edit_email(Request $request): View
    {
        return view('profile.edit-email', [
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

        return Redirect::route('profile.edit-email')->with('status', 'profile-updated');
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
