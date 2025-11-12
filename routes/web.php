<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\MekanikDashboardController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Middleware\RoleMiddleware;

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ServisController as AdminServisController ;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\SparepartController as AdminSparepartController;
use App\Http\Controllers\TransaksiController as TransaksiController;

use App\Http\Controllers\User\PelangganController as UserPelangganController ;
use App\Http\Controllers\User\BookingController as UserBookingController;

use App\Http\Controllers\MekanikController;


Route::get('/', fn() => view('landing'));


// Guest (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard redirect (otomatis sesuai role)
Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Admin-only routes
// Admin-only routes
Route::middleware('role:admin')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.admin');
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users');
    Route::get('/servis', [AdminServisController::class, 'index'])->name('admin.servis');

// Booking
    Route::get('/booking', [AdminBookingController::class, 'index'])->name('admin.booking');
    Route::get('/booking/{id}/edit', [AdminBookingController::class, 'edit'])->name('admin.booking.edit');
    Route::put('/booking/{id}', [AdminBookingController::class, 'update'])->name('admin.booking.update');
    Route::delete('/booking/{id}', [AdminBookingController::class, 'destroy'])->name('admin.booking.destroy');

    Route::get('/sparepart', [AdminSparepartController::class, 'index'])->name('admin.sparepart');
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('admin.transaksi');
});




// Mekanik-only routes
Route::middleware('role:mekanik')->prefix('mekanik')->group(function () { // Ubah prefix sesuai kebutuhan
    Route::get('/dashboard', [MekanikDashboardController::class, 'index'])->name('dashboard.mekanik'); // Ubah nama route sesuai kebutuhan
    Route::get('/servis-dikerjakan', [MekanikController::class, 'servisAktif'])->name('mekanik.servis.aktif');
    Route::get('/servis-selesai', [MekanikController::class, 'servisSelesai'])->name('mekanik.servis.selesai');
});


// Pelanggan-only routes
Route::middleware('role:user')->prefix('pelanggan')->group(function () { // Ubah prefix sesuai kebutuhan
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard.user'); // Ubah nama route sesuai kebutuhan
    Route::get('/servis', [PelangganController::class, 'servisSaya'])->name('user.servis');
    Route::get('/riwayat', [PelangganController::class, 'riwayatServis'])->name('user.riwayat');
});

// Booking User
Route::prefix('user')->middleware(['auth', 'role:pelanggan'])->group(function () {
    Route::get('booking', [App\Http\Controllers\User\BookingController::class, 'index'])->name('user.booking.index');
    Route::get('booking/create', [App\Http\Controllers\User\BookingController::class, 'create'])->name('user.booking.create');
    Route::post('booking', [App\Http\Controllers\User\BookingController::class, 'store'])->name('user.booking.store');
    Route::delete('booking/{id}', [App\Http\Controllers\User\BookingController::class, 'destroy'])->name('user.booking.destroy');
});

