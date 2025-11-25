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
        // Validasi input email dan password
        $credentials = $request->validate([
            'email' => 'required|email',    // Email harus diisi dan valid
            'password' => 'required',       // Password harus diisi
        ]);

        // Coba autentikasi user dengan data yang diberikan
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Jika berhasil, regenerasi session untuk keamanan
            $request->session()->regenerate();

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
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
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
