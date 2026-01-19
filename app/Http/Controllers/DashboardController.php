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
        if ($user->role === 'admin') {
            $data['sideBadges'] = [
                'pending_bookings' => \App\Models\Booking::where('status', 'menunggu')->count(),
                'pending_payments' => \App\Models\Pembayaran::where('status', 'pending')->count(),
                'active_servis' => \App\Models\Servis::where('status', 'dikerjakan')->count(),
            ];
        } elseif ($user->role === 'mekanik') {
            $data['sideBadges'] = [
                'assigned_bookings' => \App\Models\Booking::where('mekanik_id', $user->id)
                    ->where('status', 'disetujui')
                    ->count(),
                'active_servis' => \App\Models\Servis::whereHas('booking', function($q) use($user) {
                    $q->where('mekanik_id', $user->id);
                })->where('status', 'dikerjakan')->count(),
            ];
        }

        return response()->json($data);
    }
}
