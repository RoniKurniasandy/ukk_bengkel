<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendServiceReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-service-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim email pengingat servis berkala ke pelanggan (3 bulan setelah servis terakhir)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai pengecekan reminder servis...');

        // 1. Tentukan rentang waktu target (Tepat 3 bulan yang lalu)
        // Kita pakai startOfDay dan endOfDay agar mencakup semua jam di hari tersebut
        $targetDate = \Carbon\Carbon::now()->subMonths(3)->startOfDay();
        $targetDateEnd = \Carbon\Carbon::now()->subMonths(3)->endOfDay();

        // 2. Query Database: Cari servis yang statusnya 'selesai' DALAM rentang waktu tersebut
        $servisLama = \App\Models\Servis::where('status', 'selesai')
            ->whereBetween('waktu_selesai', [$targetDate, $targetDateEnd])
            ->with(['booking.user', 'booking.kendaraan']) // Ambil data user & kendaraan sekaligus (Eager Loading) agar ringan
            ->get();

        $count = 0;

        foreach ($servisLama as $servis) {
            // Ambil relasi booking
            $booking = $servis->booking;
            
            // Validasi: Pastikan data booking, kendaraan, dan user masih ada
            if (!$booking || !$booking->kendaraan || !$booking->user) {
                continue;
            }

            // 3. Cek Logika Anti-Spam:
            // Apakah kendaraan ini pernah servis lagi SETELAH tanggal servis terakhir yang kita cek?
            // Jika user rajin servis (misal bulan lalu baru servis), kita JANGAN kirim reminder 3-bulanan ini.
            $kendaraanId = $booking->kendaraan_id;
            
            $hasNewerService = \App\Models\Servis::whereHas('booking', function($q) use ($kendaraanId) {
                $q->where('kendaraan_id', $kendaraanId);
            })
            ->where('waktu_selesai', '>', $servis->waktu_selesai) // Waktu selesai lebih baru dari servis yang sedang dicek
            ->where('status', 'selesai')
            ->exists();

            if (!$hasNewerService) {
                // 4. Jika tidak ada servis baru, berarti saatnya kirim email reminder
                try {
                    \Illuminate\Support\Facades\Mail::to($booking->user->email)
                        ->send(new \App\Mail\ServiceReminderMail($booking->user, $booking->kendaraan));
                    
                    $this->info("Email dikirim ke: " . $booking->user->email . " (Kendaraan: " . $booking->kendaraan->plat_nomor . ")");
                    $count++;
                } catch (\Exception $e) {
                    $this->error("Gagal mengirim email ke: " . $booking->user->email . ". Error: " . $e->getMessage());
                }
            }
        }

        $this->info("Selesai. Total email terkirim: $count");
    }
}
