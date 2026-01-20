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
            'nilai' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->tipe_diskon === 'persen' && ($value < 1 || $value > 100)) {
                        $fail('Nilai persentase harus antara 1 sampai 100.');
                    }
                    if ($value < 0) {
                        $fail('Nilai voucher tidak boleh negatif.');
                    }
                },
            ],
            'min_transaksi' => 'required|numeric|min:0',
            'kuota' => 'required|integer|min:0',
            'tgl_mulai' => 'required|date',
            'tgl_berakhir' => 'required|date|after_or_equal:tgl_mulai',
        ], [
            'kode.required' => 'Kode voucher wajib diisi.',
            'kode.unique' => 'Kode voucher sudah ada.',
            'kode.max' => 'Kode voucher maksimal 50 karakter.',
            'tipe_diskon.required' => 'Tipe diskon wajib dipilih.',
            'tipe_diskon.in' => 'Tipe diskon tidak valid.',
            'nilai.required' => 'Nilai voucher wajib diisi.',
            'nilai.numeric' => 'Nilai voucher harus berupa angka.',
            'min_transaksi.required' => 'Minimal transaksi wajib diisi.',
            'min_transaksi.numeric' => 'Minimal transaksi harus berupa angka.',
            'min_transaksi.min' => 'Minimal transaksi tidak boleh negatif.',
            'kuota.required' => 'Kuota wajib diisi.',
            'kuota.integer' => 'Kuota harus berupa angka bulat.',
            'kuota.min' => 'Kuota tidak boleh negatif.',
            'tgl_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tgl_mulai.date' => 'Format tanggal mulai tidak valid.',
            'tgl_berakhir.required' => 'Tanggal berakhir wajib diisi.',
            'tgl_berakhir.date' => 'Format tanggal berakhir tidak valid.',
            'tgl_berakhir.after_or_equal' => 'Tanggal berakhir harus sama atau setelah tanggal mulai.',
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
            'nilai' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->tipe_diskon === 'persen' && ($value < 1 || $value > 100)) {
                        $fail('Nilai persentase harus antara 1 sampai 100.');
                    }
                    if ($value < 0) {
                        $fail('Nilai voucher tidak boleh negatif.');
                    }
                },
            ],
            'min_transaksi' => 'required|numeric|min:0',
            'kuota' => 'required|integer|min:0',
            'tgl_mulai' => 'required|date',
            'tgl_berakhir' => 'required|date|after_or_equal:tgl_mulai',
        ], [
            'kode.required' => 'Kode voucher wajib diisi.',
            'kode.unique' => 'Kode voucher sudah ada.',
            'kode.max' => 'Kode voucher maksimal 50 karakter.',
            'tipe_diskon.required' => 'Tipe diskon wajib dipilih.',
            'tipe_diskon.in' => 'Tipe diskon tidak valid.',
            'nilai.required' => 'Nilai voucher wajib diisi.',
            'nilai.numeric' => 'Nilai voucher harus berupa angka.',
            'min_transaksi.required' => 'Minimal transaksi wajib diisi.',
            'min_transaksi.numeric' => 'Minimal transaksi harus berupa angka.',
            'min_transaksi.min' => 'Minimal transaksi tidak boleh negatif.',
            'kuota.required' => 'Kuota wajib diisi.',
            'kuota.integer' => 'Kuota harus berupa angka bulat.',
            'kuota.min' => 'Kuota tidak boleh negatif.',
            'tgl_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tgl_mulai.date' => 'Format tanggal mulai tidak valid.',
            'tgl_berakhir.required' => 'Tanggal berakhir wajib diisi.',
            'tgl_berakhir.date' => 'Format tanggal berakhir tidak valid.',
            'tgl_berakhir.after_or_equal' => 'Tanggal berakhir harus sama atau setelah tanggal mulai.',
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
