<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EmailVerificationController extends Controller
{
    public function showOTPForm()
    {
        return view('auth.verify-otp');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $user = Auth::user();

        if ($request->otp == $user->email_verification_code) {
            // Cek kedaluwarsa (10 menit)
            if ($user->updated_at->addMinutes(10)->isPast()) {
                return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa. Silakan kirim ulang.']);
            }

            $user->forceFill([
                'email_verified_at' => Carbon::now(),
                'email_verification_code' => null,
            ])->save();

            return redirect()->route('dashboard')->with('success', 'Email Anda berhasil diverifikasi!');
        }

        return back()->withErrors(['otp' => 'Kode OTP yang Anda masukkan salah.']);
    }

    public function resend(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        $user->sendEmailVerificationNotification();

        return back()->with('success', 'Kode OTP baru telah dikirimkan ke email Anda.');
    }
}
