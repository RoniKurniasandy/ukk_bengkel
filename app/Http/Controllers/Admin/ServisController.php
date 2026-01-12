<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Servis;
use App\Models\User;
use App\Models\Stok;
use App\Models\DetailServis;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ServisController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');

        $search = $request->get('search');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $sort = $request->get('sort', 'terbaru'); // default: terbaru

        $query = Booking::with(['user', 'kendaraan', 'servis.mekanik']);

        // Filter Status
        if ($status) {
            if ($status == 'menunggu') {
                $query->where('status', 'menunggu');
            } elseif ($status == 'proses') {
                $query->whereIn('status', ['disetujui', 'dikerjakan']);
            } elseif ($status == 'selesai') {
                $query->where('status', 'selesai');
            } elseif ($status == 'tolak') {
                $query->where('status', 'ditolak');
            } elseif ($status == 'batal') {
                $query->where('status', 'dibatalkan');
            }
        }

        // Filter Pencarian (Nama, Plat Nomor, Mekanik)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                })
                    ->orWhereHas('kendaraan', function ($q) use ($search) {
                        $q->where('plat_nomor', 'like', "%{$search}%")
                            ->orWhere('merk', 'like', "%{$search}%");
                    })
                    ->orWhereHas('servis.mekanik', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        // Filter Rentang Tanggal
        if ($dateFrom && $dateTo) {
            $query->whereBetween('tanggal_booking', [$dateFrom, $dateTo]);
        } elseif ($dateFrom) {
            // Jika hanya tanggal dari yang diisi
            $query->whereDate('tanggal_booking', '>=', $dateFrom);
        } elseif ($dateTo) {
            // Jika hanya tanggal sampai yang diisi
            $query->whereDate('tanggal_booking', '<=', $dateTo);
        }

        // Sorting
        if ($sort === 'terlama') {
            $bookings = $query->orderBy('tanggal_booking', 'asc')
                ->orderBy('jam_booking', 'asc')
                ->get();
        } else {
            // Default: terbaru
            $bookings = $query->orderBy('tanggal_booking', 'desc')
                ->orderBy('jam_booking', 'desc')
                ->get();
        }

        return view('admin.servis.index', compact('bookings'));
    }

    public function edit($id)
    {
        $booking = Booking::with(['user', 'kendaraan', 'servis.detailServis.stok'])->findOrFail($id);
        $mekanik = User::where('role', 'mekanik')->get();
        $stokList = Stok::where('jumlah', '>', 0)->get(); // Only show items in stock

        return view('admin.servis.edit', compact('booking', 'mekanik', 'stokList'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        // Validasi: Jika status sudah final, tidak boleh ganti mekanik atau status
        if (in_array($booking->status, ['selesai', 'ditolak', 'dibatalkan'])) {
            // Jika mencoba mengubah status
            if ($request->status != $booking->status) {
                return redirect()->back()->with('error', 'Status tidak dapat diubah karena sudah final.');
            }

            // Jika user mencoba mengganti mekanik saat status sudah final
            if ($request->has('mekanik_id') && $request->mekanik_id != optional($booking->servis)->mekanik_id) {
                $request->request->remove('mekanik_id');
            }
        }

        $request->validate([
            'status' => 'required',
            'mekanik_id' => 'required_if:status,disetujui',
        ]);

        $booking->status = $request->status;

        // Jika disetujui, assign mekanik ke booking
        if ($request->status === 'disetujui' && $request->mekanik_id) {
            $booking->mekanik_id = $request->mekanik_id;
        }

        $booking->save();

        return redirect()->route('admin.servis.index')
            ->with('success', 'Booking berhasil disetujui dan mekanik ditugaskan. Servis akan dimulai saat mekanik menekan tombol "Kerjakan".');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.servis.index')->with('success', 'Data berhasil dihapus.');
    }

    public function updateStatusQuick(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $newStatus = $request->input('status');

        // Validasi: Jika status akan diubah menjadi "selesai", pastikan ada mekanik yang ditugaskan
        if ($newStatus === 'selesai') {
            $servis = Servis::where('booking_id', $booking->booking_id)->first();

            if (!$servis || !$servis->mekanik_id) {
                return redirect()->back()->with('error', 'Tidak dapat menyelesaikan servis. Mekanik belum ditugaskan.');
            }

            // Update status servis juga dan set waktu selesai
            $servis->update([
                'status' => 'selesai',
                'waktu_selesai' => now() // Set waktu selesai real-time
            ]);

            // Create Transaction Record (Pemasukan)
            Transaksi::create([
                'user_id' => Auth::id(), // Admin who finalized it
                'servis_id' => $servis->id,
                'jenis_transaksi' => 'pemasukan',
                'sumber' => 'servis',
                'total' => $servis->estimasi_biaya,
                'keterangan' => 'Pembayaran Servis - ' . $booking->kendaraan->plat_nomor,
                'status' => 'selesai'
            ]);
        }

        // Update status booking
        $booking->status = $newStatus;
        $booking->save();

        return redirect()->route('admin.servis.index')
            ->with('success', 'Status berhasil diperbarui.');
    }

    public function addItem(Request $request, $id)
    {
        $request->validate([
            'stok_id' => 'required|exists:stok,stok_id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $booking = Booking::with('servis')->findOrFail($id);

        // Prevent adding items to completed services
        if (in_array($booking->status, ['selesai', 'ditolak', 'dibatalkan'])) {
            return redirect()->back()->with('error', 'Tidak dapat menambah barang pada servis yang sudah selesai.');
        }

        // Get stock item
        $stok = Stok::findOrFail($request->stok_id);

        // Check stock availability
        if ($stok->jumlah < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi. Tersedia: ' . $stok->jumlah . ' ' . $stok->satuan);
        }

        DB::beginTransaction();
        try {
            // Check if item already exists in this service
            $existingDetail = DetailServis::where('servis_id', $booking->servis->id)
                ->where('stok_id', $request->stok_id)
                ->first();

            if ($existingDetail) {
                // Update existing  item quantity
                $existingDetail->jumlah += $request->jumlah;
                $existingDetail->save();
            } else {
                // Create new detail record
                DetailServis::create([
                    'servis_id' => $booking->servis->id,
                    'stok_id' => $request->stok_id,
                    'jumlah' => $request->jumlah,
                    'harga_satuan' => $stok->harga_jual,
                ]);
            }

            // Reduce stock
            $stok->decrement('jumlah', $request->jumlah);

            // Update estimated cost: Add parts cost to existing base price
            // estimasi_biaya already contains base service price (harga layanan)
            // We just need to recalculate total parts cost and update
            $hargaLayanan = $booking->layanan->harga ?? 0;
            $totalParts = $booking->servis->getTotalBiaya(); // Sum of all parts
            $booking->servis->update(['estimasi_biaya' => $hargaLayanan + $totalParts]);

            DB::commit();
            return redirect()->back()->with('success', 'Barang berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan barang: ' . $e->getMessage());
        }
    }

    public function removeItem($detailId)
    {
        DB::beginTransaction();
        try {
            $detail = DetailServis::with('servis.booking')->findOrFail($detailId);

            // Prevent removing items from completed services
            if (in_array($detail->servis->booking->status, ['selesai', 'ditolak', 'dibatalkan'])) {
                return redirect()->back()->with('error', 'Tidak dapat menghapus barang dari servis yang sudah selesai.');
            }

            // Restore stock
            $stok = Stok::where('stok_id', $detail->stok_id)->first();
            $stok->increment('jumlah', $detail->jumlah);

            // Delete detail
            $detail->delete();

            // Update estimated cost: Recalculate as base price + remaining parts
            $hargaLayanan = $detail->servis->booking->layanan->harga ?? 0;
            $totalParts = $detail->servis->getTotalBiaya(); // Sum of remaining parts
            $detail->servis->update(['estimasi_biaya' => $hargaLayanan + $totalParts]);

            DB::commit();
            return redirect()->back()->with('success', 'Barang berhasil dihapus dan stok dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus barang: ' . $e->getMessage());
        }
    }
}
