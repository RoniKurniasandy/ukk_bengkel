<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Servis;

class MekanikController extends Controller
{
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
            'status' => 'selesai'
        ]);

        // Opsional: Update status booking juga jika perlu sinkronisasi
        $servis->booking->update(['status' => 'selesai']);

        return redirect()->route('mekanik.servis.aktif')
            ->with('success', 'Servis berhasil diselesaikan.');
    }
}
