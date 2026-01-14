<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Kami tidak dapat menemukan pengguna dengan alamat email tersebut.']);
        }

        // Generate 6 Digit OTP
        $token = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => $token, // Simpan OTP sebagai token
                'created_at' => Carbon::now()
            ]
        );

        Mail::send('auth.emails.otp-reset', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Kode OTP Reset Password');
        });

        // Redirect ke halaman input OTP dengan membawa email di session
        return redirect()->route('password.verify.otp.form')->with([
            'success' => 'Kami telah mengirimkan kode OTP ke email Anda!',
            'email' => $request->email
        ]);
    }

    public function showVerifyForm()
    {
        if (!session('email')) {
             return redirect()->route('password.request');
        }
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6'
        ]);

        $exists = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->otp)
            ->first();

        if ($exists) {
            // Jika OTP valid, redirect ke halaman reset password dengan token (OTP) tersebut
            // Kita gunakan OTP sebagai token reset password di URL
            return redirect()->route('password.reset', ['token' => $request->otp, 'email' => $request->email]);
        } 
        
        return back()->with('error', 'Kode OTP tidak valid atau sudah kadaluarsa.')->with('email', $request->email);
    }
}
