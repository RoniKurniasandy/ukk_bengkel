<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Servis;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $date = $request->get('date');
        $paymentStatus = $request->get('payment_status');
        $paymentMethod = $request->get('payment_method');

        // 1. Query Pembayaran (Verifikasi)
        $queryPembayaran = Pembayaran::with(['servis.booking.user', 'servis.booking.kendaraan', 'servis.detailServis.stok', 'servis.booking.layanan']);

        if ($search) {
            $queryPembayaran->where(function ($q) use ($search) {
                $q->whereHas('servis.booking.user', function ($u) use ($search) {
                    $u->where('nama', 'like', "%{$search}%");
                })
                    ->orWhere('servis_id', $search);
            });
        }
        if ($date) {
            $queryPembayaran->whereDate('created_at', $date);
        }
        if ($paymentMethod) {
            $queryPembayaran->where('metode_pembayaran', $paymentMethod);
        }
        // Note: Payment Status filter usually applies to the Service's payment status, 
        // but for the Verification tab (Pembayaran model), we might filter by the payment's own status or the service's.
        // Given the context, 'payment_status' likely refers to 'lunas/belum_bayar' which is on the Service model.
        // However, the Verification tab lists individual payments. 
        // If the user wants to filter payments by "Lunas", it implies showing payments for services that are Lunas.
        if ($paymentStatus) {
            $queryPembayaran->whereHas('servis', function ($q) use ($paymentStatus) {
                $q->where('status_pembayaran', $paymentStatus);
            });
        }

        $pembayarans = $queryPembayaran->orderBy('created_at', 'desc')->get();

        // 2. Query Tagihan Belum Lunas (Kasir)
        $queryTagihan = Servis::with(['booking.user', 'booking.kendaraan', 'detailServis.stok', 'booking.layanan'])
            ->whereIn('status', ['dikerjakan', 'selesai']);

        // Default filter for unpaid bills tab if no specific status is requested, 
        // OR if the requested status is relevant to unpaid bills (belum_bayar, dp_lunas).
        // If user filters by 'lunas', this tab should probably be empty or show lunas services?
        // The original logic was: ->whereIn('status_pembayaran', ['belum_bayar', 'dp_lunas'])
        // We should adapt this.

        if ($paymentStatus) {
            $queryTagihan->where('status_pembayaran', $paymentStatus);
        } else {
            // Default behavior: show only unpaid/partial
            $queryTagihan->whereIn('status_pembayaran', ['belum_bayar', 'dp_lunas']);
        }

        if ($search) {
            $queryTagihan->where(function ($q) use ($search) {
                $q->whereHas('booking.user', function ($u) use ($search) {
                    $u->where('nama', 'like', "%{$search}%");
                })
                    ->orWhere('id', $search);
            });
        }
        if ($date) {
            $queryTagihan->whereDate('created_at', $date);
        }

        // Payment Method filter is tricky for Unpaid Bills (Servis model) as they might not have a payment yet.
        // But if they have a partial payment (DP), we could check that. 
        // Or maybe the user means the "intended" method? 
        // For now, if filtering by method, we can check if ANY existing payment for this service matches.
        if ($paymentMethod) {
            $queryTagihan->whereHas('pembayarans', function ($q) use ($paymentMethod) {
                $q->where('metode_pembayaran', $paymentMethod);
            });
        }

        $tagihanBelumLunas = $queryTagihan->orderBy('created_at', 'desc')->get();

        return view('admin.pembayaran.index', compact('pembayarans', 'tagihanBelumLunas'));
    }

    public function create($servisId)
    {
        $servis = Servis::with(['booking.user.membershipTier', 'booking.kendaraan'])->findOrFail($servisId);

        // Hitung sisa tagihan
        $totalBayar = Pembayaran::where('servis_id', $servis->id)
            ->where('status', 'diterima')
            ->sum('jumlah');
        $sisaTagihan = max(0, $servis->estimasi_biaya - $totalBayar);

        return view('admin.pembayaran.create', compact('servis', 'sisaTagihan'));
    }

    public function store(Request $request, $servisId)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:0', // Min 0 allows fully discounted free service
            'metode_pembayaran' => 'required|in:tunai,transfer',
            'catatan' => 'nullable|string',
            'kode_voucher' => 'nullable|string',
            'diskon_manual' => 'nullable|numeric|min:0',
            'alasan_diskon_manual' => 'required_if:diskon_manual,>,0',
        ]);

        $servis = Servis::with(['booking.user', 'detailServis'])->findOrFail($servisId);
        
        // Calculate Components
        $subtotal = $servis->estimasi_biaya;
        $partTotal = $servis->detailServis->sum('subtotal'); // Assuming detailServis has subtotal column
        $jasaTotal = max(0, $subtotal - $partTotal);

        // --- Discount Calculation Start ---
        $discountService = app(\App\Services\DiscountService::class);
        $user = $servis->booking->user;

        // 1. Member Discount
        $diskonMember = $discountService->calculateMemberDiscount($user, $subtotal, $jasaTotal, $partTotal);

        // 2. Voucher Discount
        $diskonVoucher = 0;
        $kodeVoucher = $request->kode_voucher;
        if ($kodeVoucher) {
            $voucherResult = $discountService->calculateVoucherDiscount($kodeVoucher, $subtotal, $user ? $user->id : null, $servisId);
            if ($voucherResult['error']) {
                 return redirect()->back()->with('error', $voucherResult['error'])->withInput();
            }
            $diskonVoucher = $voucherResult['amount'];
        }

        // 3. Manual Discount
        $diskonManual = $request->diskon_manual ?? 0;

        // Final Calculation
        $grandTotal = max(0, $subtotal - $diskonMember - $diskonVoucher - $diskonManual);
        // --- Discount Calculation End ---

        DB::beginTransaction();
        try {
            // Validate Payment Amount vs Grand Total
            // If full payment is intended, amount should be >= Grand Total (minus any previous payments)
            $previouslyPaid = Pembayaran::where('servis_id', $servis->id)->where('status', 'diterima')->sum('jumlah');
            $remainingBill = max(0, $grandTotal - $previouslyPaid);

            // Validasi: Jika ini adalah pembayaran awal dan jumlahnya >= grandTotal, dipaksa lunas.
            // Namun user biasanya manual input. Kita tambahkan warning/logic:
            if ($previouslyPaid == 0 && $request->jumlah >= $grandTotal && $request->jumlah > 0) {
                 // Info: Pembayaran ini mencukupi untuk lunas.
            }
            
            // 1. Buat record Pembayaran (Uang yang diterima)
            $pembayaran = Pembayaran::create([
                'servis_id' => $servis->id,
                'jumlah' => $request->jumlah,
                'subtotal' => $subtotal,
                'diskon_member' => $diskonMember,
                'diskon_voucher' => $diskonVoucher,
                'kode_voucher' => $kodeVoucher,
                'grand_total' => $grandTotal,
                'diskon_manual' => $diskonManual,
                'alasan_diskon_manual' => $request->alasan_diskon_manual,
                'metode_pembayaran' => $request->metode_pembayaran,
                'jenis_pembayaran' => ($request->jumlah >= $remainingBill) ? 'full' : 'dp', 
                'bukti_pembayaran' => null, 
                'status' => 'diterima',
                'catatan' => $request->catatan ?? 'Pembayaran Manual Admin'
            ]);

            // 2. Update status pembayaran servis
            $totalBayarSekarang = $previouslyPaid + $request->jumlah;

            if ($totalBayarSekarang >= $grandTotal) { // Compare against Grand Total (Discounted Price)
                $servis->status_pembayaran = 'lunas';
                // Trigger Membership Upgrade only on Full Payment
                if ($user) {
                    $discountService->checkAndUpgradeMembership($user);
                }
            } elseif ($totalBayarSekarang > 0) {
                $servis->status_pembayaran = 'dp_lunas';
            }
            $servis->save();

            // 3. Buat record Transaksi
            // Transaksi records the "Event", but usually we track the Payment amount as "Total" in simple accounting.
            // However, with discounts, we want to record the full breakdown.
            
            // Logic: Is this transaction record representing the *payment* or the *invoice*?
            // Existing code: 'total' => $request->jumlah. This means it tracks cash flow.
            // The discount columns should probably be stored to indicate "This payment had these discounts applied" 
            // OR we create a final "Invoice" transaction when lunas?
            // Let's stick to: Transaksi tracks the Financial Event.
            // If this is a payment, 'total' is the money in.
            // But we added columns `diskon_member`, etc to `transaksi`. 
            // Usually discounts apply to the whole Order, not just one partial payment.
            // Let's save the discount details ONLY if it's the final payment or if we decide to store it on every payment?
            // Better: Store discount details. 'subtotal' here might be the Service subtotal.
            
            $sisaTagihan = max(0, $grandTotal - $totalBayarSekarang);
            $keterangan = 'Pembayaran Manual (' . ucfirst($request->metode_pembayaran) . ')';
            $keterangan .= ' - Servis #' . $servis->id;

            if ($sisaTagihan > 0) {
                $keterangan .= ' (Sisa: Rp ' . number_format($sisaTagihan, 0, ',', '.') . ')';
            } else {
                $keterangan .= ' (Lunas)';
            }

            // Decrement Voucher Quota if used
            if ($kodeVoucher) {
                // Ideally check if not already decreed for this service? 
                // For simplicity, we assume one voucher per service and decrement now.
                 \App\Models\Voucher::where('kode', $kodeVoucher)->decrement('kuota');
            }

            Transaksi::create([
                'user_id' => auth()->id(),
                'servis_id' => $servis->id,
                'jenis_transaksi' => 'pemasukan',
                'sumber' => 'servis',
                'total' => $request->jumlah, // Actual money received
                'keterangan' => $keterangan,
                'status' => 'selesai',
                
                // Discount Details (Snapshot)
                'subtotal' => $subtotal,
                'diskon_member' => $diskonMember,
                'diskon_voucher' => $diskonVoucher,
                'kode_voucher' => $kodeVoucher,
                'diskon_manual' => $diskonManual,
                'alasan_diskon_manual' => $request->alasan_diskon_manual,
                'grand_total' => $grandTotal
            ]);

            // Update User's Total Transactions & Check for Upgrade
            // Since this is manual payment, we accumulate right away
            if ($user) {
                $user->increment('total_transaksi', $request->jumlah);
                $discountService->checkAndUpgradeMembership($user->fresh());
            }

            DB::commit();
            return redirect()->route('admin.pembayaran.index')->with('success', 'Pembayaran berhasil dicatat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mencatat pembayaran: ' . $e->getMessage())->withInput();
        }
    }

    public function verify(Request $request, $id)
    {
        $pembayaran = Pembayaran::with('servis.booking.user')->findOrFail($id);
        $action = $request->input('action'); // 'terima' atau 'tolak'

        DB::beginTransaction();
        try {
            if ($action === 'terima') {
                // Update status pembayaran
                $pembayaran->status = 'diterima';
                $pembayaran->save();

                // Update status_pembayaran di servis
                $servis = $pembayaran->servis;
                
                // Jika pembayaran ini memiliki data diskon, kita anggap ini adalah "Final Bill" adjustment
                // Namun untuk amannya, kita hitung status lunas berdasarkan grand_total jika ada, atau estimasi_biaya jika tidak
                $targetTotal = $pembayaran->grand_total ?? $servis->estimasi_biaya;

                // Hitung total yang sudah dibayar (yang statusnya diterima)
                $totalBayar = Pembayaran::where('servis_id', $servis->id)
                    ->where('status', 'diterima')
                    ->sum('jumlah');

                // Update status pembayaran servis
                if ($totalBayar >= $targetTotal) {
                    $servis->status_pembayaran = 'lunas';
                } elseif ($totalBayar > 0) {
                    $servis->status_pembayaran = 'dp_lunas';
                } else {
                    $servis->status_pembayaran = 'belum_bayar';
                }
                $servis->save();

                // Update Total Transaksi Pelanggan & Cek Upgrade membership
                $user = $servis->booking->user;
                if ($user) {
                    $user->increment('total_transaksi', $pembayaran->jumlah);
                    
                    $discountService = app(\App\Services\DiscountService::class);
                    $discountService->checkAndUpgradeMembership($user->fresh());
                }

                // Buat record transaksi
                $sisaTagihan = max(0, $targetTotal - $totalBayar);
                $keterangan = 'Pembayaran ';

                if ($pembayaran->jenis_pembayaran === 'dp') {
                    $keterangan .= 'DP';
                } elseif ($pembayaran->jenis_pembayaran === 'pelunasan') {
                    $keterangan .= 'Pelunasan';
                } else {
                    $keterangan .= 'Lunas';
                }

                $keterangan .= ' - Servis #' . $servis->id;
                if ($sisaTagihan > 0) {
                    $keterangan .= ' (Sisa: Rp ' . number_format($sisaTagihan, 0, ',', '.') . ')';
                }

                Transaksi::create([
                    'user_id' => $servis->booking->user_id,
                    'servis_id' => $servis->id,
                    'jenis_transaksi' => 'pemasukan',
                    'sumber' => 'servis',
                    'total' => $pembayaran->jumlah,
                    'subtotal' => $pembayaran->subtotal,
                    'diskon_member' => $pembayaran->diskon_member,
                    'diskon_voucher' => $pembayaran->diskon_voucher,
                    'kode_voucher' => $pembayaran->kode_voucher,
                    'grand_total' => $pembayaran->grand_total,
                    'keterangan' => $keterangan,
                    'status' => 'selesai'
                ]);

                // Update Voucher Quota if applicable
                if ($pembayaran->kode_voucher) {
                    \App\Models\Voucher::where('kode', $pembayaran->kode_voucher)->decrement('kuota');
                }

                DB::commit();
                return redirect()->back()->with('success', 'Pembayaran berhasil diterima dan tercatat di transaksi.');
            } else {
                // Tolak pembayaran
                $pembayaran->status = 'ditolak';
                $pembayaran->catatan = $request->input('catatan');
                $pembayaran->save();

                DB::commit();
                return redirect()->back()->with('success', 'Pembayaran ditolak.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }
}
