<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\MekanikDashboardController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Auth\EmailVerificationController;


use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ServisController as AdminServisController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\StokController as AdminStokController;
use App\Http\Controllers\TransaksiController as TransaksiController;

use App\Http\Controllers\User\PelangganController as UserPelangganController;
use App\Http\Controllers\User\BookingController as UserBookingController;
use App\Http\Controllers\User\KendaraanController as UserKendaraanController;
use App\Http\Controllers\User\ServisController as UserServisController;
use App\Http\Controllers\MekanikController;
use App\Models\User;

Route::get('/', [LandingController::class, 'index'])->name('landing');


// Guest (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Password Reset
    Route::get('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/verify-otp', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showVerifyForm'])->name('password.verify.otp.form');
    Route::post('/password/verify-otp', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'verifyOtp'])->name('password.verify.otp');
    Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard redirect (otomatis sesuai role)
Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('vouchers/check', [\App\Http\Controllers\Admin\VoucherController::class, 'check'])->name('admin.vouchers.check');
    Route::post('/notifications/mark-all-read', [DashboardController::class, 'markAllAsRead'])->name('notifications.markAllRead');
});

// Email Verification (OTP)
Route::middleware('auth')->group(function() {
    Route::get('/email/verify', [EmailVerificationController::class, 'showOTPForm'])
        ->name('verification.notice');

    Route::post('/email/verify-otp', [EmailVerificationController::class, 'verify'])
        ->middleware(['throttle:6,1'])
        ->name('verification.verify.otp');

    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])
        ->middleware(['throttle:6,1'])
        ->name('verification.send');
});


// Admin-only routes
// Admin-only routes
// Admin-only routes
Route::middleware(['role:admin', 'verified'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.admin');
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.user.index');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('admin.user.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('admin.user.store');

    // Manajemen Servis (Gabungan Booking & Servis)
    Route::get('/servis', [AdminServisController::class, 'index'])->name('admin.servis.index');
    Route::get('/servis/{id}/edit', [AdminServisController::class, 'edit'])->name('admin.servis.edit');
    Route::put('/servis/{id}', [AdminServisController::class, 'update'])->name('admin.servis.update');
    Route::post('/servis/{id}/update-status', [AdminServisController::class, 'updateStatusQuick'])->name('admin.servis.updateStatus');
    Route::post('/servis/{id}/add-item', [AdminServisController::class, 'addItem'])->name('admin.servis.addItem');
    Route::delete('/servis/item/{detailId}', [AdminServisController::class, 'removeItem'])->name('admin.servis.removeItem');
    Route::delete('/servis/{id}', [AdminServisController::class, 'destroy'])->name('admin.servis.destroy');

    Route::resource('stok', AdminStokController::class)->names([
        'index' => 'admin.stok.index',
        'create' => 'admin.stok.create',
        'store' => 'admin.stok.store',
        'show' => 'admin.stok.show',
        'edit' => 'admin.stok.edit',
        'update' => 'admin.stok.update',
        'destroy' => 'admin.stok.destroy',
    ]);

    // Penjualan Stok
    Route::get('/penjualan', [App\Http\Controllers\Admin\PenjualanController::class, 'create'])->name('admin.penjualan.create');
    Route::post('/penjualan', [App\Http\Controllers\Admin\PenjualanController::class, 'store'])->name('admin.penjualan.store');


    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('admin.transaksi');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('admin.transaksi.show');

    // Pembayaran
    Route::get('/pembayaran', [App\Http\Controllers\Admin\PembayaranController::class, 'index'])->name('admin.pembayaran.index');
    Route::post('/pembayaran/{id}/verify', [App\Http\Controllers\Admin\PembayaranController::class, 'verify'])->name('admin.pembayaran.verify');
    Route::get('/pembayaran/{id}/bayar', [App\Http\Controllers\Admin\PembayaranController::class, 'create'])->name('admin.pembayaran.create');
    Route::post('/pembayaran/{id}/bayar', [App\Http\Controllers\Admin\PembayaranController::class, 'store'])->name('admin.pembayaran.store');

    // Layanan
    Route::resource('layanan', \App\Http\Controllers\Admin\LayananController::class)->names([
        'index' => 'admin.layanan.index',
        'create' => 'admin.layanan.create',
        'store' => 'admin.layanan.store',
        'edit' => 'admin.layanan.edit',
        'update' => 'admin.layanan.update',
        'destroy' => 'admin.layanan.destroy',
    ]);

    // Manajemen Voucher (CRUD)
    Route::resource('vouchers', \App\Http\Controllers\Admin\VoucherController::class)->names([
        'index' => 'admin.vouchers.index',
        'create' => 'admin.vouchers.create',
        'store' => 'admin.vouchers.store',
        'edit' => 'admin.vouchers.edit',
        'update' => 'admin.vouchers.update',
        'destroy' => 'admin.vouchers.destroy',
    ])->except(['show']);

    // Profil Admin
    Route::get('/profil', [App\Http\Controllers\Admin\ProfilController::class, 'index'])->name('admin.profil.index');
    Route::get('/profil/edit', [App\Http\Controllers\Admin\ProfilController::class, 'edit'])->name('admin.profil.edit');
    Route::put('/profil/update', [App\Http\Controllers\Admin\ProfilController::class, 'update'])->name('admin.profil.update');
    Route::put('/profil/password', [App\Http\Controllers\Admin\ProfilController::class, 'updatePassword'])->name('admin.profil.password');
});




// Mekanik-only routes
// Mekanik-only routes
Route::middleware(['role:mekanik', 'verified'])->prefix('mekanik')->group(function () {
    Route::get('/dashboard', [MekanikDashboardController::class, 'index'])->name('dashboard.mekanik');

    // Jadwal Servis
    Route::get('/jadwal-servis', [MekanikController::class, 'jadwalServis'])->name('mekanik.jadwal.servis');
    Route::post('/booking/{id}/mulai', [MekanikController::class, 'startServis'])->name('mekanik.booking.start');

    Route::get('/servis-dikerjakan', [MekanikController::class, 'servisAktif'])->name('mekanik.servis.aktif');
    Route::get('/servis-selesai', [MekanikController::class, 'servisSelesai'])->name('mekanik.servis.selesai');
    Route::get('/servis/{id}/detail', [MekanikController::class, 'detail'])->name('mekanik.servis.detail');
    Route::put('/servis/{id}', [MekanikController::class, 'updateStatus'])->name('mekanik.servis.update');
    Route::post('/servis/{id}/add-item', [MekanikController::class, 'addItem'])->name('mekanik.servis.addItem');
    Route::delete('/servis/item/{detailId}', [MekanikController::class, 'removeItem'])->name('mekanik.servis.removeItem');

    // Profil Mekanik
    Route::get('/profil', [App\Http\Controllers\Mekanik\ProfilController::class, 'index'])->name('mekanik.profil.index');
    Route::get('/profil/edit', [App\Http\Controllers\Mekanik\ProfilController::class, 'edit'])->name('mekanik.profil.edit');
    Route::put('/profil/update', [App\Http\Controllers\Mekanik\ProfilController::class, 'update'])->name('mekanik.profil.update');
    Route::put('/profil/password', [App\Http\Controllers\Mekanik\ProfilController::class, 'updatePassword'])->name('mekanik.profil.password');
});


// Pelanggan-only routes
// Pelanggan-only routes
Route::middleware(['auth', 'role:pelanggan', 'verified'])->prefix('pelanggan')->group(function () {

    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard.user'); // Ubah nama route sesuai kebutuhan

    Route::get('/kendaraan', [UserKendaraanController::class, 'index'])->name('user.kendaraan');
    Route::post('/kendaraan', [UserKendaraanController::class, 'store'])->name('user.kendaraan.store');
    Route::delete('/kendaraan/{id}', [UserKendaraanController::class, 'destroy'])->name('user.kendaraan.destroy');

    // Servis Saya (riwayat servis yang sudah disetujui/dikerjakan)
    Route::get('/servis', [App\Http\Controllers\User\ServisController::class, 'index'])->name('user.servis');

    Route::get('/booking', [UserBookingController::class, 'index'])->name('user.booking.index');
    Route::get('/booking/create', [UserBookingController::class, 'create'])->name('user.booking.create');
    Route::post('/booking/store', [UserBookingController::class, 'store'])->name('user.booking.store');
    Route::get('/booking/{id}', [UserBookingController::class, 'show'])->name('user.booking.show');
    Route::delete('/booking/{id}', [UserBookingController::class, 'destroy'])->name('user.booking.destroy');

    // Pembayaran
    Route::get('/pembayaran/{servisId}', [App\Http\Controllers\User\PembayaranController::class, 'create'])->name('user.pembayaran.create');
    Route::post('/pembayaran/{servisId}', [App\Http\Controllers\User\PembayaranController::class, 'store'])->name('user.pembayaran.store');

    // Profil
    Route::get('/profil', [App\Http\Controllers\User\ProfilController::class, 'index'])->name('user.profil.index');
    Route::get('/profil/edit', [App\Http\Controllers\User\ProfilController::class, 'edit'])->name('user.profil.edit');
    Route::put('/profil/update', [App\Http\Controllers\User\ProfilController::class, 'update'])->name('user.profil.update');
    Route::put('/profil/password', [App\Http\Controllers\User\ProfilController::class, 'updatePassword'])->name('user.profil.password');

    // Phone Verification
    Route::get('/profil/verify-phone', [App\Http\Controllers\User\PhoneVerificationController::class, 'showVerifyForm'])->name('user.profil.phone.verify');
    Route::post('/profil/verify-phone', [App\Http\Controllers\User\PhoneVerificationController::class, 'verify']);
    Route::post('/profil/verify-phone/resend', [App\Http\Controllers\User\PhoneVerificationController::class, 'resend'])->name('user.profil.phone.resend');
});

require __DIR__ . '/debug.php';
