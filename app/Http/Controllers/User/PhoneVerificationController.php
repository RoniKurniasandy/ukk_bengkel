<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\PhoneVerification;

class PhoneVerificationController extends Controller
{
    public function showVerifyForm()
    {
        return view('user.profil.verify-phone');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        $user = Auth::user();

        if ($request->code == $user->phone_verification_code) {
            $user->update([
                'no_hp' => $user->pending_no_hp,
                'pending_no_hp' => null,
                'phone_verification_code' => null
            ]);

            return redirect()->route('user.profil.index')->with('success', 'Nomor HP berhasil diperbarui.');
        }

        return back()->withErrors(['code' => 'Kode verifikasi yang Anda masukkan salah.']);
    }

    public function resend()
    {
        $user = Auth::user();
        if (!$user->pending_no_hp) {
            return redirect()->route('user.profil.index');
        }

        $code = rand(100000, 999999);
        $user->update(['phone_verification_code' => $code]);
        $user->notify(new PhoneVerification($code));

        return back()->with('success', 'Kode verifikasi baru telah dikirimkan ke email Anda.');
    }
}
