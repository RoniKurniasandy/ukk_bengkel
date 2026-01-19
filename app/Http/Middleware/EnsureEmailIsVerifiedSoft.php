<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class EnsureEmailIsVerifiedSoft
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $redirectToRoute
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|null
     */
    public function handle(Request $request, Closure $next, $redirectToRoute = null)
    {
        if (! $request->user() ||
            ($request->user() instanceof MustVerifyEmail &&
            ! $request->user()->hasVerifiedEmail())) {
            
            // Jika user belum verifikasi email
            // Biarkan mereka mengakses Dashboard saja
            $allowedRoutes = ['dashboard', 'dashboard.admin', 'dashboard.mekanik', 'dashboard.user', 'verification.notice', 'verification.verify', 'logout', 'notifications.markAllRead'];
            
            if ($request->routeIs($allowedRoutes)) {
                return $next($request);
            }

            // Jika mencoba akses route lain, redirect ke dashboard dengan pesan
            return Redirect::guest(route('dashboard'))->with('warning', 'Silakan verifikasi email Anda untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
