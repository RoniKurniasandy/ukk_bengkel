<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        // Mengembalikan view login
        return view('auth.login');
    }

    // Proses login user
    public function login(Request $request)
    {
        // Validasi input login (bisa email atau no_hp) dan password
        $request->validate([
            'login' => 'required|string',
            'password' => 'required',
            'g-recaptcha-response' => 'required',
        ]);

        // Verify reCAPTCHA
        $response = \Illuminate\Support\Facades\Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!$response->json()['success']) {
             return back()->withErrors(['captcha' => 'Verifikasi reCAPTCHA gagal, silakan coba lagi.'])->onlyInput('login');
        }

        $login = $request->input('login');
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'no_hp';

        $credentials = [
            $fieldType => $login,
            'password' => $request->password,
        ];

        // Coba autentikasi user dengan data yang diberikan
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Jika berhasil, regenerasi session untuk keamanan
            $request->session()->regenerate();

            /** @var \App\Models\User $user */
            $user = Auth::user(); // Ambil data user yang sedang login

            // Redirect ke dashboard sesuai role user
            if ($user->role === 'admin') {
                return redirect()->route('dashboard.admin');
            } elseif ($user->role === 'mekanik') {
                return redirect()->route('dashboard.mekanik');
            } else {
                return redirect()->route('dashboard.user');
            }
        }

        // Jika gagal login, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'login' => 'Email/Nomor HP atau password salah.',
        ])->onlyInput('login');
    }

    // Proses logout user
    public function logout(Request $request)
    {
        Auth::logout(); // Logout user
        $request->session()->invalidate(); // Hapus session
        $request->session()->regenerateToken(); // Regenerasi CSRF token
        return redirect()->route('landing'); // Redirect ke halaman landing/homepage
    }
}
