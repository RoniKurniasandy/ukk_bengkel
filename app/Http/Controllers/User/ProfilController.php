<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use App\Notifications\PhoneVerification;


class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user->load('membershipTier'); // Eager load for performance
        return view('user.profil.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.profil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:100',
            'no_hp' => 'nullable|string|max:20|unique:users,no_hp,' . $user->id,
            'alamat' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        $data = [
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ];

        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($user->foto && file_exists(public_path('storage/photos/' . $user->foto))) {
                unlink(public_path('storage/photos/' . $user->foto));
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('photos', $filename, 'public');
            $data['foto'] = $filename;
        }

        // Handle Phone Number Change Verification
        if ($request->no_hp && $request->no_hp != $user->no_hp) {
            $code = rand(100000, 999999);
            $user->update([
                'pending_no_hp' => $request->no_hp,
                'phone_verification_code' => $code,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'foto' => $data['foto'] ?? $user->foto
            ]);

            $user->notify(new PhoneVerification($code));

            return redirect()->route('user.profil.phone.verify')
                ->with('info', 'Silakan verifikasi nomor HP baru Anda melalui kode yang dikirim ke email.');
        }

        $user->update($data);

        return redirect()->route('user.profil.index')->with('success', 'Profil berhasil diperbarui.');

    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Auth::user();

        // Check old password
        if (!Hash::check($request->password_lama, $user->password)) {
            return redirect()->back()->withErrors(['password_lama' => 'Password lama tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->password_baru),
        ]);

        return redirect()->route('user.profil.index')->with('success', 'Password berhasil diubah.');
    }
}
