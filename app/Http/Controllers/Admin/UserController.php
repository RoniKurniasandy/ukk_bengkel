<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    // Method untuk menampilkan daftar user
    public function index(\Illuminate\Http\Request $request)
    {
        // Query builder change to support filtering
        $query = User::where('role', '!=', 'admin');

        // Filter: Search (Nama, Email, No HP)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        // Filter: Role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter: Tanggal Daftar
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // Urutkan berdasarkan role (mekanik, pelanggan) kemudian abjad nama
        $users = $query->orderByRaw("CASE 
                         WHEN role = 'mekanik' THEN 1
                         WHEN role = 'pelanggan' THEN 2
                         ELSE 3
                     END")
            ->orderBy('nama', 'asc')
            ->get();

        // Kirim data user ke view 'admin.user.index'
        return view('admin.user.index', compact('users'));
    }
    public function create()
    {
        return view('admin.user.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'no_hp' => 'nullable|string|max:15|unique:users,no_hp',
            'alamat' => 'nullable|string',
            'role' => 'required|in:admin,mekanik,pelanggan',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'role' => $request->role,
        ]);

        $user->sendEmailVerificationNotification();

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'no_hp' => 'nullable|string|max:15|unique:users,no_hp,' . $user->id,
            'alamat' => 'nullable|string',
            'role' => 'required|in:admin,mekanik,pelanggan',
        ]);

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.user.index')->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.user.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus.');
    }
}
