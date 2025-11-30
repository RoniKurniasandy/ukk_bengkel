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
        $servis = Servis::with(['booking.user', 'booking.kendaraan'])->findOrFail($servisId);

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
            'jumlah' => 'required|numeric|min:1',
            'metode_pembayaran' => 'required|in:tunai,transfer',
            'catatan' => 'nullable|string'
        ]);

        $servis = Servis::findOrFail($servisId);

        DB::beginTransaction();
        try {
            // 1. Buat record Pembayaran (langsung diterima)
            $pembayaran = Pembayaran::create([
                'servis_id' => $servis->id,
                'jumlah' => $request->jumlah,
                'metode_pembayaran' => $request->metode_pembayaran,
                'jenis_pembayaran' => ($request->jumlah >= $servis->estimasi_biaya) ? 'full' : 'dp', // Simplifikasi logic
                'bukti_pembayaran' => null, // Manual payment doesn't need proof upload
                'status' => 'diterima',
                'catatan' => $request->catatan ?? 'Pembayaran Manual oleh Admin'
            ]);

            // 2. Update status pembayaran servis
            $totalBayar = Pembayaran::where('servis_id', $servis->id)
                ->where('status', 'diterima')
                ->sum('jumlah');

            if ($totalBayar >= $servis->estimasi_biaya) {
                $servis->status_pembayaran = 'lunas';
            } elseif ($totalBayar > 0) {
                $servis->status_pembayaran = 'dp_lunas';
            }
            $servis->save();

            // 3. Buat record Transaksi
            $sisaTagihan = max(0, $servis->estimasi_biaya - $totalBayar);
            $keterangan = 'Pembayaran Manual (' . ucfirst($request->metode_pembayaran) . ')';
            $keterangan .= ' - Servis #' . $servis->id;

            if ($sisaTagihan > 0) {
                $keterangan .= ' (Sisa: Rp ' . number_format($sisaTagihan, 0, ',', '.') . ')';
            } else {
                $keterangan .= ' (Lunas)';
            }

            Transaksi::create([
                'user_id' => auth()->id(),
                'servis_id' => $servis->id,
                'jenis_transaksi' => 'pemasukan',
                'sumber' => 'servis',
                'total' => $request->jumlah,
                'keterangan' => $keterangan,
                'status' => 'selesai'
            ]);

            DB::commit();
            return redirect()->route('admin.pembayaran.index')->with('success', 'Pembayaran berhasil dicatat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mencatat pembayaran: ' . $e->getMessage());
        }
    }

    public function verify(Request $request, $id)
    {
        $pembayaran = Pembayaran::with('servis')->findOrFail($id);
        $action = $request->input('action'); // 'terima' atau 'tolak'

        DB::beginTransaction();
        try {
            if ($action === 'terima') {
                // Update status pembayaran
                $pembayaran->status = 'diterima';
                $pembayaran->save();

                // Update status_pembayaran di servis
                $servis = $pembayaran->servis;
                $estimasiBiaya = $servis->estimasi_biaya;

                // Hitung total yang sudah dibayar
                $totalBayar = Pembayaran::where('servis_id', $servis->id)
                    ->where('status', 'diterima')
                    ->sum('jumlah');

                // Update status pembayaran servis
                if ($totalBayar >= $estimasiBiaya) {
                    $servis->status_pembayaran = 'lunas';
                } elseif ($totalBayar > 0) {
                    $servis->status_pembayaran = 'dp_lunas';
                } else {
                    $servis->status_pembayaran = 'belum_bayar';
                }
                $servis->save();

                // Buat record transaksi
                $sisaTagihan = max(0, $estimasiBiaya - $totalBayar);
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
                    'user_id' => auth()->id(),
                    'servis_id' => $servis->id,
                    'jenis_transaksi' => 'pemasukan',
                    'sumber' => 'servis',
                    'total' => $pembayaran->jumlah,
                    'keterangan' => $keterangan,
                    'status' => 'selesai'
                ]);

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
