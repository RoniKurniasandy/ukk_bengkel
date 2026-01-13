<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::orderBy('created_at', 'desc')->get();
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.vouchers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:vouchers,kode|max:50', // Uppercase handled by mutator or simple input transform
            'tipe_diskon' => 'required|in:nominal,persen',
            'nilai' => 'required|numeric|min:0',
            'min_transaksi' => 'required|numeric|min:0',
            'kuota' => 'required|integer|min:0',
            'tgl_mulai' => 'nullable|date',
            'tgl_berakhir' => 'nullable|date|after_or_equal:tgl_mulai',
        ]);
        
        // Force Uppercase Code
        $data = $request->all();
        $data['kode'] = strtoupper($request->kode);
        $data['is_active'] = $request->has('is_active'); // Default checkbox handling

        Voucher::create($data);

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil dibuat.');
    }

    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.vouchers.edit', compact('voucher'));
    }

    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);
        
        $request->validate([
            'kode' => 'required|max:50|unique:vouchers,kode,' . $voucher->id,
            'tipe_diskon' => 'required|in:nominal,persen',
            'nilai' => 'required|numeric|min:0',
            'min_transaksi' => 'required|numeric|min:0',
            'kuota' => 'required|integer|min:0',
            'tgl_mulai' => 'nullable|date',
            'tgl_berakhir' => 'nullable|date|after_or_equal:tgl_mulai',
        ]);
        
        $data = $request->all();
        $data['kode'] = strtoupper($request->kode);
        $data['is_active'] = $request->has('is_active');

        $voucher->update($data);

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();
        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil dihapus.');
    }

    public function check(Request $request)
    {
        $code = $request->input('code');
        $subtotal = $request->input('subtotal');
        $userId = $request->input('user_id');
        $serviceId = $request->input('servis_id');

        $discountService = app(\App\Services\DiscountService::class);
        $result = $discountService->calculateVoucherDiscount($code, $subtotal, $userId, $serviceId);

        if ($result['error']) {
            return response()->json(['valid' => false, 'message' => $result['error']]);
        }

        return response()->json([
            'valid' => true,
            'amount' => $result['amount'],
            'voucher' => $result['voucher']
        ]);
    }
}
