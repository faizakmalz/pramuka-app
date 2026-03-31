<?php

use App\Http\Controllers\EventsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KenaikanGolonganController;
use App\Http\Controllers\TkkController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PublicEventsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/cek-speed', function() {
    return "Fast!";
});

// ========== PUBLIC ROUTES (No Auth Required) ==========
Route::get('/events/public', [PublicEventsController::class, 'index'])->name('public.events');
Route::get('/events/public/data', [PublicEventsController::class, 'getEvents'])->name('public.events.data');

// ========== AUTHENTICATED ROUTES ==========
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard/anggota', [DashboardController::class, 'anggotaData'])->middleware(['auth', 'verified'])->name('dashboard.anggota');
Route::get('/dashboard/golongan-counts', [DashboardController::class, 'golonganCounts'])->middleware(['auth', 'verified']);
Route::get('/dashboard/events', [DashboardController::class, 'dashboardEvents'])->middleware(['auth', 'verified']);

// Anggota
Route::get('/anggota', [AnggotaController::class, 'index'])->middleware(['auth', 'verified'])->name('anggota');
Route::get('/data-anggota', [AnggotaController::class, 'getAnggotas'])->middleware(['auth', 'verified'])->name('data-anggota');

Route::middleware(['auth', 'verified'])->group(function () {
    // Anggota CRUD
    Route::get('/anggota/create', [AnggotaController::class, 'create'])->name('anggota.create');
    Route::post('/anggota', [AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('/anggota/{nomor_anggota}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');
    Route::put('/anggota/{nomor_anggota}', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('/anggota/{nomor_anggota}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');
    Route::post('/anggota/import', [AnggotaController::class, 'import'])->name('anggota.import');
    Route::get('/anggota/export', [AnggotaController::class, 'export'])->name('anggota.export');
    Route::get('/anggota/golongan-pramuka', [AnggotaController::class, 'getGolonganPramuka']);
    Route::get('/anggota/{nomor_anggota}/kta', [AnggotaController::class, 'showKta']);

    // Kenaikan Golongan
    Route::get('/kenaikan', [KenaikanGolonganController::class, 'index'])->name('kenaikan');
    Route::post('/kenaikan', [KenaikanGolonganController::class, 'store'])->name('kenaikan.store');
    Route::get('/kenaikan-golongan/sertifikat/{nomor_sertifikat}', [KenaikanGolonganController::class, 'showSertifikat'])->name('kenaikan.sertifikat.show');
    Route::get('/kenaikan-golongan/sertifikat/{nomor_sertifikat}/download', [KenaikanGolonganController::class, 'downloadSertifikat'])->name('kenaikan.sertifikat.download');

    // TKK (Tanda Kecakapan Khusus)
    Route::get('/tkk', [TkkController::class, 'index'])->name('tkk');
    Route::post('/tkk', [TkkController::class, 'store'])->name('tkk.store');
    Route::get('/tkk/sertifikat/{nomor_sertifikat}', [TkkController::class, 'showSertifikat'])->name('tkk.sertifikat.show');
    Route::get('/tkk/sertifikat/{nomor_sertifikat}/download', [TkkController::class, 'downloadSertifikat'])->name('tkk.sertifikat.download');

    // Settings (Profil Organisasi)
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
});

// Events (Jadwal Event)
Route::get('/jadwal-event', [EventsController::class, 'index'])->middleware(['auth', 'verified'])->name('jadwal-event');
Route::get('/events', [EventsController::class, 'getEvents'])->middleware(['auth', 'verified'])->name('event');
Route::get('/events/create', [EventsController::class, 'create'])->middleware(['auth', 'verified'])->name('event.create');
Route::post('/events', [EventsController::class, 'store'])->middleware(['auth', 'verified'])->name('event.store');
Route::get('/events/{id}/edit', [EventsController::class, 'edit'])->middleware(['auth', 'verified'])->name('event.edit');
Route::put('/events/{id}', [EventsController::class, 'update'])->middleware(['auth', 'verified'])->name('event.update');
Route::delete('/events', [EventsController::class, 'destroy'])->middleware(['auth', 'verified'])->name('event.destroy');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';