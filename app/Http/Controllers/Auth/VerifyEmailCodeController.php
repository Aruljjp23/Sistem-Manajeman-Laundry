<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerifyEmailCodeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        if ($user->verification_code === $request->code) {
            $user->markEmailAsVerified();
            $user->verification_code = null;
            $user->save();

            return redirect()->intended(route('dashboard', absolute: false))->with('verified', true);
        }

        return back()->withErrors(['code' => 'Kode verifikasi tidak valid.']);
    }
}
