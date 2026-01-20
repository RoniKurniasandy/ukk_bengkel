<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('dashboard.admin');
        } elseif ($user->role === 'mekanik') {
            return redirect()->route('dashboard.mekanik');
        } else {
            return redirect()->route('dashboard.user');
        }
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }

    public function getRealtimeUpdates()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $data = [
            'unreadNotificationsCount' => $user->unreadNotifications()->count(),
            'recentNotifications' => view('layouts.partials.notifications_list', [
                'recentNotifications' => $user->notifications()->take(5)->get()
            ])->render(),
        ];

        // Add role-specific badges
        // Add role-specific badges (Keys must match IDs in sidebar.blade.php: badge-{key-with-dashes})
        if ($user->role === 'admin') {
            $data['sideBadges'] = [
                'booking_waiting' => \App\Models\Booking::where('status', 'menunggu')->count(),
                'payment_pending' => \App\Models\Pembayaran::where('status', 'pending')->count(),
            ];
        } elseif ($user->role === 'mekanik') {
            $data['sideBadges'] = [
                'jadwal_servis' => \App\Models\Booking::where('mekanik_id', $user->id)
                    ->where('status', 'disetujui')
                    ->count(),
                'servis_aktif' => \App\Models\Servis::whereHas('booking', function($q) use($user) {
                    $q->where('mekanik_id', $user->id);
                })->where('status', 'dikerjakan')->count(),
            ];
        } elseif ($user->role === 'pelanggan') {
            $data['sideBadges'] = [
                'servis_selesai' => \App\Models\Booking::where('user_id', $user->id)->where('status', 'dikerjakan')->count(),
                'booking_aktif' => \App\Models\Booking::where('user_id', $user->id)->whereIn('status', ['menunggu', 'disetujui'])->count(),
            ];
        }

        return response()->json($data);
    }
}
