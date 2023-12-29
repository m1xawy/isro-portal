<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SRO\Account\TbUser;
use App\Models\SRO\Portal\MuhAlteredInfo;
use App\Models\SRO\Portal\MuUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:6', 'max:32', 'confirmed'],
        ]);

        MuUser::where('JID', $request->user()->jid)->update(['UserPwd' => md5($request->password)]);
        TbUser::where('PortalJID', $request->user()->jid)->update(['password' => md5($request->password)]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }
}
