<?php

namespace App\Services;

use App\Models\MembershipTier;
use App\Models\Voucher;
use App\Models\User;
use Carbon\Carbon;

class DiscountService
{
    /**
     * Calculate Member Discount based on Tier
     */
    public function calculateMemberDiscount(?User $user, $subtotal, $jasaTotal = 0, $partTotal = 0)
    {
        if (!$user || !$user->membership_tier_id) {
            return 0;
        }

        $tier = MembershipTier::find($user->membership_tier_id);
        if (!$tier) return 0;

        // Validasi tambahan: Pastikan total transaksi pelanggan benar-benar sudah mencapai syarat tier tersebut
        // Ini mencegah "Member Hantu" yang dapet diskon padahal syarat (5jt) belum tercapai
        if ($user->total_transaksi < $tier->min_transaksi) {
            return 0;
        }

        // Hitung diskon berdasarkan Jasa dan Part terpisah (jika data tersedia)
        if ($jasaTotal > 0 || $partTotal > 0) {
            $diskonJasa = $jasaTotal * ($tier->diskon_jasa / 100);
            $diskonPart = $partTotal * ($tier->diskon_part / 100);
            return $diskonJasa + $diskonPart;
        }

        // Fallback: Diskon Flat dari Subtotal
        return $subtotal * ($tier->diskon_jasa / 100);
    }

    /**
     * Validate and Calculate Voucher Discount
     */
    public function calculateVoucherDiscount($code, $subtotal, $userId, $serviceId = null)
    {
        if (empty($code)) return ['amount' => 0, 'error' => null];

        // Pencegahan penggunaan voucher yang sama 2x pada servis yang sama (misal DP then Pelunasan)
        if ($serviceId) {
            $existingUsage = \App\Models\Pembayaran::where('servis_id', $serviceId)
                ->where('kode_voucher', $code)
                ->where('status', '!=', 'ditolak')
                ->exists();

            if ($existingUsage) {
                return ['amount' => 0, 'error' => 'Kode ini sudah digunakan pada pembayaran sebelumnya di servis ini.'];
            }
        }

        $voucher = Voucher::where('kode', $code)->first();

        if (!$voucher) {
            return ['amount' => 0, 'error' => 'Kode tidak valid'];
        }

        if (!$voucher->is_active) {
            return ['amount' => 0, 'error' => 'Voucher tidak aktif.'];
        }

        if ($voucher->tgl_mulai && Carbon::now()->lt($voucher->tgl_mulai)) {
            return ['amount' => 0, 'error' => 'Voucher belum berlaku.'];
        }

        if ($voucher->tgl_berakhir && Carbon::now()->gt(Carbon::parse($voucher->tgl_berakhir)->endOfDay())) {
            return ['amount' => 0, 'error' => 'Voucher sudah kadaluarsa.'];
        }

        if ($voucher->kuota > 0) {
            // Cek penggunaan (perlu tabel voucher_usage kalau mau strict per user, 
            // tapi untuk sekarang kita cek global kuota aja dulu atau kurangi nanti)
            // Implementation detail: Decrement dilakukan saat transaksi sukses.
        }
        
        if ($voucher->kuota == 0) { // Jika 0 dan bukan unlimited (misal logic 0 = habis)
             // Opsional: Sepakati 0 = habis atau -1 = unlimited. 
             // Di migration default 0. Mari asumsikan kita pakai field tersendiri atau cek logic.
             // Let's assume > 0 is quota, 0 is empty (habis), -1 is unlimited.
             // For safety let's just say if quota is 0, it's invalid unless handled differently.
             // Revision: Logic migration default 0. Let's treat 0 as "Habis" to be safe.
             return ['amount' => 0, 'error' => 'Kuota voucher habis.'];
        }

        if ($subtotal < $voucher->min_transaksi) {
            return ['amount' => 0, 'error' => 'Minimal transaksi Rp ' . number_format($voucher->min_transaksi)];
        }

        // Calculate
        $amount = 0;
        if ($voucher->tipe_diskon == 'nominal') {
            $amount = $voucher->nilai;
        } else {
            $amount = $subtotal * ($voucher->nilai / 100);
        }

        // Ensure calculation doesn't exceed subtotal
        if ($amount > $subtotal) $amount = $subtotal;

        return ['amount' => $amount, 'error' => null, 'voucher' => $voucher];
    }

    /**
     * Check and Upgrade Member Tier
     */
    public function checkAndUpgradeMembership(User $user)
    {
        // Get all tiers ordered by min_transaksi desc
        $tiers = MembershipTier::orderBy('min_transaksi', 'desc')->get();

        foreach ($tiers as $tier) {
            if ($user->total_transaksi >= $tier->min_transaksi) {
                // Jika user belum di tier ini atau tier sekarang lebih rendah
                if ($user->membership_tier_id != $tier->id) {
                     // Update User
                     $user->membership_tier_id = $tier->id;
                     $user->save();
                     return $tier; // Return new tier info
                }
                break; // Sudah di tier tertinggi yang eligible
            }
        }
        return null;
    }
}
