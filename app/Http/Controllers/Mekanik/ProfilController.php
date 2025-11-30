<?php

namespace App\Http\Controllers\Mekanik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('mekanik.profil.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('mekanik.profil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:255',
        ]);

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('mekanik.profil.index')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password_lama, $user->password)) {
            return redirect()->back()->withErrors(['password_lama' => 'Password lama tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->password_baru),
        ]);

        return redirect()->route('mekanik.profil.index')->with('success', 'Password berhasil diubah.');
    }
}
