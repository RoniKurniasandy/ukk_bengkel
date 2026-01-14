<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Pembayaran;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $unreadNotificationsCount = 0;
            $recentNotifications = collect(); // Empty collection
            $badges = [];

            if (Auth::check()) {
                $user = Auth::user();
                
                // Get unread notifications
                $unreadNotificationsCount = $user->unreadNotifications()->count();
                $recentNotifications = $user->notifications()->take(5)->get();

                // Specific Badge Logic based on Role
                if ($user->role === 'admin') {
                    $badges = [
                        'booking_waiting' => Booking::where('status', 'menunggu')->count(),
                        'payment_pending' => Pembayaran::where('status', 'pending')->count(),
                    ];
                } elseif ($user->role === 'mekanik') {
                    $badges = [
                        'jadwal_servis' => Booking::where('mekanik_id', $user->id)->where('status', 'disetujui')->count(),
                        'servis_aktif' => Booking::where('mekanik_id', $user->id)->where('status', 'dikerjakan')->count(),
                    ];
                } elseif ($user->role === 'pelanggan') {
                    $badges = [
                        'servis_selesai' => Booking::where('user_id', $user->id)->where('status', 'dikerjakan')->count(),
                        'booking_aktif' => Booking::where('user_id', $user->id)->whereIn('status', ['menunggu', 'disetujui'])->count(),
                    ];
                }
            }

            $view->with([
                'unreadNotificationsCount' => $unreadNotificationsCount,
                'recentNotifications' => $recentNotifications,
                'sideBadges' => $badges,
            ]);
        });
    }

}
