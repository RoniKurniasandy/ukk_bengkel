<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Servis;
use App\Models\Booking;
use App\Models\Stok;
use App\Models\DetailServis;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class MekanikController extends Controller
{
    // Jadwal Servis - Show approved bookings waiting to be started
    public function jadwalServis()
    {
        $bookings = Booking::with(['layanan', 'kendaraan', 'user'])
            ->where('mekanik_id', Auth::id())
            ->where('status', 'disetujui')
            ->whereDoesntHave('servis') // Only show bookings without Servis record yet
            ->orderBy('tanggal_booking', 'asc')
            ->orderBy('jam_booking', 'asc')
            ->get();

        return view('mekanik.jadwal_servis', compact('bookings'));
    }

    // Start working on a service
    public function startServis(Request $request, $bookingId)
    {
        $booking = Booking::with('layanan')
            ->where('booking_id', $bookingId)
            ->where('mekanik_id', Auth::id())
            ->where('status', 'disetujui')
            ->firstOrFail();

        // Check if Servis already exists
        if ($booking->servis) {
            return redirect()->route('mekanik.jadwal.servis')
                ->with('error', 'Servis ini sudah dimulai.');
        }

        // Create Servis record
        $hargaLayanan = $booking->layanan->harga ?? 0;

        Servis::create([
            'booking_id' => $booking->booking_id,
            'mekanik_id' => Auth::id(),
            'status' => 'dikerjakan',
            'estimasi_biaya' => $hargaLayanan,
            'waktu_mulai' => now(),
        ]);

        // Update booking status to dikerjakan
        $booking->update(['status' => 'dikerjakan']);

        return redirect()->route('mekanik.servis.aktif')
            ->with('success', 'Servis berhasil dimulai. Anda sekarang dapat menambahkan sparepart jika diperlukan.');
    }

    public function servisAktif()
    {
        $servis = Servis::with(['booking.kendaraan', 'booking.user'])
            ->where('mekanik_id', Auth::id())
            ->where('status', 'dikerjakan')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('mekanik.servis_aktif', compact('servis'));
    }

    public function servisSelesai()
    {
        $servis = Servis::with(['booking.kendaraan', 'booking.user'])
            ->where('mekanik_id', Auth::id())
            ->where('status', 'selesai')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('mekanik.servis_selesai', compact('servis'));
    }

    public function updateStatus(Request $request, $id)
    {
        $servis = Servis::where('id', $id)
            ->where('mekanik_id', Auth::id())
            ->firstOrFail();

        $servis->update([
            'status' => 'selesai',
            'waktu_selesai' => now()
        ]);

        // Opsional: Update status booking juga jika perlu sinkronisasi
        $servis->booking->update(['status' => 'selesai']);

        // Create Transaction Record (Pemasukan) - Status Pending (Waiting for payment/admin)
        Transaksi::create([
            'user_id' => Auth::id(), // Mekanik who finished it
            'servis_id' => $servis->id,
            'jenis_transaksi' => 'pemasukan',
            'sumber' => 'servis',
            'total' => $servis->estimasi_biaya,
            'keterangan' => 'Servis Selesai oleh Mekanik - ' . $servis->booking->kendaraan->plat_nomor,
            'status' => 'pending' // Pending until admin confirms payment? Or just 'selesai'? Let's stick to pending for mechanic.
        ]);

        return redirect()->route('mekanik.servis.aktif')
            ->with('success', 'Servis berhasil diselesaikan.');
    }

    public function detail($id)
    {
        $servis = Servis::with(['booking.kendaraan', 'booking.user', 'detailServis.stok'])
            ->where('id', $id)
            ->where('mekanik_id', Auth::id())
            ->firstOrFail();

        $stokList = Stok::where('jumlah', '>', 0)->get();

        return view('mekanik.servis_detail', compact('servis', 'stokList'));
    }

    public function addItem(Request $request, $id)
    {
        $request->validate([
            'stok_id' => 'required|exists:stok,stok_id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $servis = Servis::with('booking')
            ->where('id', $id)
            ->where('mekanik_id', Auth::id())
            ->firstOrFail();

        // Prevent adding items to completed services
        if ($servis->status == 'selesai') {
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
            $existingDetail = DetailServis::where('servis_id', $servis->id)
                ->where('stok_id', $request->stok_id)
                ->first();

            if ($existingDetail) {
                // Update existing item quantity
                $existingDetail->jumlah += $request->jumlah;
                $existingDetail->save();
            } else {
                // Create new detail record
                DetailServis::create([
                    'servis_id' => $servis->id,
                    'stok_id' => $request->stok_id,
                    'jumlah' => $request->jumlah,
                    'harga_satuan' => $stok->harga_jual,
                ]);
            }

            // Reduce stock
            $stok->decrement('jumlah', $request->jumlah);

            // Update estimated cost: Add parts cost to base price
            $hargaLayanan = $servis->booking->layanan->harga ?? 0;
            $totalParts = $servis->getTotalBiaya();
            $servis->update(['estimasi_biaya' => $hargaLayanan + $totalParts]);

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
            $detail = DetailServis::with('servis')->findOrFail($detailId);

            // Verify this is mekanik's service
            if ($detail->servis->mekanik_id != Auth::id()) {
                return redirect()->back()->with('error', 'Unauthorized.');
            }

            // Prevent removing items from completed services
            if ($detail->servis->status == 'selesai') {
                return redirect()->back()->with('error', 'Tidak dapat menghapus barang dari servis yang sudah selesai.');
            }

            // Restore stock
            $stok = Stok::where('stok_id', $detail->stok_id)->first();
            $stok->increment('jumlah', $detail->jumlah);

            // Delete detail
            $detail->delete();

            // Update estimated cost: Recalculate as base price + remaining parts
            $hargaLayanan = $detail->servis->booking->layanan->harga ?? 0;
            $totalParts = $detail->servis->getTotalBiaya();
            $detail->servis->update(['estimasi_biaya' => $hargaLayanan + $totalParts]);

            DB::commit();
            return redirect()->back()->with('success', 'Barang berhasil dihapus dan stok dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus barang: ' . $e->getMessage());
        }
    }
}
