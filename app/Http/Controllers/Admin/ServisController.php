<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Servis;
use App\Models\User;

class ServisController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');

        $query = Booking::with(['user', 'kendaraan', 'servis.mekanik']);

        if ($status) {
            if ($status == 'menunggu') {
                $query->where('status', 'menunggu');
            } elseif ($status == 'proses') {
                $query->where('status', 'disetujui'); // Disetujui = Sedang dikerjakan (biasanya)
            } elseif ($status == 'selesai') {
                $query->where('status', 'selesai');
            } elseif ($status == 'tolak') {
                $query->where('status', 'ditolak');
            } elseif ($status == 'batal') {
                $query->where('status', 'dibatalkan');
            }
        }

        $bookings = $query->orderBy('created_at', 'desc')->get();

        return view('admin.servis.index', compact('bookings'));
    }

    public function edit($id)
    {
        $booking = Booking::with(['user', 'kendaraan', 'servis'])->findOrFail($id);
        $mekanik = User::where('role', 'mekanik')->get();

        return view('admin.servis.edit', compact('booking', 'mekanik'));
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
        $booking->save();

        // Jika disetujui, buat atau update data servis
        if ($request->status === 'disetujui') {
            $existingServis = Servis::where('booking_id', $booking->booking_id)->first();

            if (!$existingServis) {
                Servis::create([
                    'booking_id' => $booking->booking_id,
                    'mekanik_id' => $request->mekanik_id,
                    'status' => 'dikerjakan',
                ]);
            } else {
                // Update mekanik jika ada perubahan
                $existingServis->update([
                    'mekanik_id' => $request->mekanik_id
                ]);
            }
        }

        return redirect()->route('admin.servis.index')
            ->with('success', 'Status servis berhasil diperbarui');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.servis.index')->with('success', 'Data berhasil dihapus.');
    }
}
