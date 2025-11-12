<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sparepart;

class SparepartController extends Controller
{
    public function index()
    {
        $spareparts = Sparepart::latest()->get();
        return view('admin.sparepart.index', compact('spareparts'));
    }

    public function create()
    {
        return view('admin.sparepart.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sparepart' => 'required|string|max:255',
            'kode_sparepart' => 'required|string|max:100|unique:spareparts,kode_sparepart',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        Sparepart::create($request->all());
        return redirect()->route('admin.sparepart.index')->with('success', 'Sparepart berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $sparepart = Sparepart::findOrFail($id);
        return view('admin.sparepart.edit', compact('sparepart'));
    }

    public function show($id)
    {
        $sparepart = Sparepart::findOrFail($id);
        return view('admin.sparepart.show', compact('sparepart'));
    }


    public function update(Request $request, $id)
    {
        $sparepart = Sparepart::findOrFail($id);

        $request->validate([
            'nama_sparepart' => 'required|string|max:255',
            'kode_sparepart' => 'required|string|max:100|unique:spareparts,kode_sparepart,' . $sparepart->id,
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $sparepart->update($request->all());
        return redirect()->route('admin.sparepart.index')->with('success', 'Sparepart berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $sparepart = Sparepart::findOrFail($id);
        $sparepart->delete();

        return redirect()->route('admin.sparepart.index')->with('success', 'Sparepart berhasil dihapus.');
    }
}
