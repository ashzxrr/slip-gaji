<?php
use App\Http\Controllers\{
    DashboardController,
    KaryawanController,
    PeriodeController,
    SlipGajiController,
    ProfileAdminController
};

use App\Http\Controllers\Karyawan\AuthController as PortalAuthController;
use App\Http\Controllers\Karyawan\DashboardController as PortalDashboardController;
use App\Http\Controllers\Karyawan\PortalSlipController;
use App\Http\Controllers\Karyawan\ProfileController as PortalProfileController;
use Illuminate\Support\Facades\Route;

// Auth routes (dari Breeze)
require __DIR__.'/auth.php';

// Protected routes
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Karyawan
    Route::resource('karyawan', KaryawanController::class)
        ->except(['show']);
    Route::post('karyawan/{karyawan}/reset-password', [KaryawanController::class, 'resetPassword'])
        ->name('karyawan.resetPassword');
    Route::post('karyawan/kirim-kredensial', [KaryawanController::class, 'kirimKredensial'])
        ->name('karyawan.kirimKredensial');
    Route::post('karyawan/{karyawan}/kirim-kredensial', [KaryawanController::class, 'kirimKredensialKaryawan'])
        ->name('karyawan.kirimKredensialKaryawan');

    // Periode
    Route::get('periode', [PeriodeController::class, 'index'])->name('periode.index');
    Route::get('periode/create', [PeriodeController::class, 'create'])->name('periode.create');
    Route::post('periode', [PeriodeController::class, 'store'])->name('periode.store');
    Route::delete('periode/{periode}', [PeriodeController::class, 'destroy'])->name('periode.destroy');

    // Slip Gaji
    Route::prefix('periode/{periode}/slip')->name('periode.slip.')->group(function () {
        Route::get('/', [SlipGajiController::class, 'index'])->name('index');
        Route::get('/input/{karyawan}', [SlipGajiController::class, 'create'])->name('create');
        Route::post('/input/{karyawan}', [SlipGajiController::class, 'store'])->name('store');
        Route::get('/preview/{slip}', [SlipGajiController::class, 'preview'])->name('preview');
        Route::post('/kirim/{slip}', [SlipGajiController::class, 'kirim'])->name('kirim');
        Route::post('/kirim-semua', [SlipGajiController::class, 'kirimSemua'])->name('kirimSemua');
        Route::post('/salin', [SlipGajiController::class, 'salinDariSebelumnya'])->name('salin');
    });

    // Profile Admin
    Route::get('/profile', [ProfileAdminController::class, 'edit'])->name('admin.profile');
    Route::put('/profile', [ProfileAdminController::class, 'update'])->name('admin.profile.update');
    Route::put('/profile/password', [ProfileAdminController::class, 'updatePassword'])->name('admin.profile.password');
    Route::get('/profile/change-password/otp', [ProfileAdminController::class, 'showChangePasswordOtp'])
        ->name('admin.profile.otp.form');

    Route::post('/profile/change-password/otp', [ProfileAdminController::class, 'verifyChangePasswordOtp'])
        ->name('admin.profile.otp.verify');
});

// Portal Karyawan
Route::prefix('portal')->name('portal.')->group(function () {

    // Guest (belum login)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [PortalAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [PortalAuthController::class, 'login'])->name('login.post');
        Route::get('/otp', [PortalAuthController::class, 'showOtpForm'])->name('otp.form');
        Route::post('/otp', [PortalAuthController::class, 'verifyOtp'])->name('otp.verify');
    });

    // Auth karyawan
    Route::middleware(['portal.auth', 'must.change.password'])->group(function () {
        Route::get('/dashboard', [PortalDashboardController::class, 'index'])->name('dashboard');
        Route::get('/slip', [PortalDashboardController::class, 'index'])->name('slip.index');
        Route::get('/slip/{slip}', [PortalSlipController::class, 'show'])->name('slip.show');
        Route::get('/slip/{slip}/download', [PortalDashboardController::class, 'downloadSlip'])->name('slip.download');
        Route::get('/profile', [PortalProfileController::class, 'edit'])->name('profile');
        Route::put('/profile', [PortalProfileController::class, 'update'])->name('profile.update');

        // Change password routes must be excluded from the redirect, so we register them here as well
        Route::get('/change-password', [PortalProfileController::class, 'showChangePassword'])->name('password.change');
        Route::post('/change-password', [PortalProfileController::class, 'changePassword'])->name('password.update');
        
        // Notifikasi
        Route::prefix('notifikasi')->name('notifikasi.')->group(function() {
            Route::get('/', [\App\Http\Controllers\Karyawan\NotifikasiController::class, 'index'])->name('index');
            Route::post('/{notifikasi}/read', [\App\Http\Controllers\Karyawan\NotifikasiController::class, 'markAsRead'])->name('read');
            Route::post('/read-all', [\App\Http\Controllers\Karyawan\NotifikasiController::class, 'markAllAsRead'])->name('readAll');
            Route::delete('/{notifikasi}', [\App\Http\Controllers\Karyawan\NotifikasiController::class, 'destroy'])->name('destroy');
        });
    });

    Route::post('/logout', [PortalAuthController::class, 'logout'])->name('logout');
});

// Temporary signed URL untuk PDF (tidak perlu auth)
Route::get('/slip-pdf/{slip}', [SlipGajiController::class, 'streamPdf'])
    ->name('slip.stream')
    ->middleware('signed');