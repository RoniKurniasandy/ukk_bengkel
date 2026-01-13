<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function create($servisId)
    {
        $servis = \App\Models\Servis::with(['booking.layanan', 'booking.kendaraan', 'booking.user.membershipTier', 'detailServis'])->findOrFail($servisId);

        // Cek apakah user berhak melihat servis ini (security check)
        if ($servis->booking->user_id !== auth()->id()) {
            abort(403);
        }

        // Calculate current bill for summary
        $subtotal = $servis->estimasi_biaya;
        $previouslyPaid = \App\Models\Pembayaran::where('servis_id', $servis->id)->where('status', 'diterima')->sum('jumlah');
        $partTotal = $servis->detailServis->sum('subtotal');
        $jasaTotal = max(0, $subtotal - $partTotal);

        $discountService = app(\App\Services\DiscountService::class);
        $diskonMember = $discountService->calculateMemberDiscount(auth()->user(), $subtotal, $jasaTotal, $partTotal);

        return view('user.pembayaran.create', compact('servis', 'diskonMember', 'previouslyPaid', 'partTotal', 'subtotal'));
    }

    public function store(Request $request, $servisId)
    {
        $servis = \App\Models\Servis::with(['booking.user', 'detailServis'])->findOrFail($servisId);

        // Security check
        if ($servis->booking->user_id !== auth()->id()) {
            abort(403);
        }

        // Validasi input
        $request->validate([
            'jenis_pembayaran' => 'required|in:dp,pelunasan,full',
            'metode_pembayaran' => 'required|in:transfer,tunai',
            'jumlah' => 'nullable|numeric|min:0',
            'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
            'kode_voucher' => 'nullable|string',
        ]);

        $discountService = app(\App\Services\DiscountService::class);
        $user = auth()->user();
        
        // Calculate Components
        $subtotal = $servis->estimasi_biaya;
        $partTotal = $servis->detailServis->sum('subtotal');
        $jasaTotal = max(0, $subtotal - $partTotal);

        // 1. Member Discount
        $diskonMember = $discountService->calculateMemberDiscount($user, $subtotal, $jasaTotal, $partTotal);

        // 2. Voucher Discount
        $diskonVoucher = 0;
        $kodeVoucher = $request->kode_voucher;
        if ($kodeVoucher) {
            $voucherResult = $discountService->calculateVoucherDiscount($kodeVoucher, $subtotal, $user->id, $servisId);
            if ($voucherResult['error']) {
                return redirect()->back()->with('error', $voucherResult['error'])->withInput();
            }
            $diskonVoucher = $voucherResult['amount'];
        }

        // Final Calculation
        $grandTotal = max(0, $subtotal - $diskonMember - $diskonVoucher);

        // Set jumlah berdasarkan jenis pembayaran
        if ($request->jenis_pembayaran === 'full') {
            $jumlah = $grandTotal;
        } else {
            $jumlah = $request->jumlah;
            
            // Validasi: DP tidak boleh >= Grand Total
            if ($request->jenis_pembayaran === 'dp' && $jumlah >= $grandTotal) {
                return redirect()->back()->with('error', 'Jumlah DP tidak boleh menyamai atau melebihi total biaya (Rp ' . number_format($grandTotal, 0, ',', '.') . '). Silakan pilih jenis pembayaran "Lunas".')->withInput();
            }
        }

        // Validasi manual untuk transfer harus ada bukti
        if ($request->metode_pembayaran === 'transfer' && !$request->hasFile('bukti_pembayaran')) {
            return redirect()->back()->withErrors(['bukti_pembayaran' => 'Bukti pembayaran wajib diupload untuk metode transfer.'])->withInput();
        }

        $path = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        $servis->pembayarans()->create([
            'jumlah' => $jumlah,
            'subtotal' => $subtotal,
            'diskon_member' => $diskonMember,
            'diskon_voucher' => $diskonVoucher,
            'kode_voucher' => $kodeVoucher,
            'grand_total' => $grandTotal,
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'metode_pembayaran' => $request->metode_pembayaran,
            'bukti_pembayaran' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('user.servis')->with('success', 'Pembayaran berhasil dikirim dan menunggu verifikasi admin.');
    }
}
