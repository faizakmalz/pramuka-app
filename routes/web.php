<?php

use App\Http\Controllers\EventsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KenaikanGolonganController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(middleware: ['auth', 'verified'])->name('dashboard');
Route::get('/dashboard/anggota', [DashboardController::class, 'anggotaData'])->middleware(['auth', 'verified'])->name('dashboard.anggota');
Route::get('/anggota', [AnggotaController::class, 'index'])->middleware(['auth', 'verified'])->name('anggota');
Route::get('/data-anggota', [AnggotaController::class, 'getAnggotas'])->middleware(['auth', 'verified'])->name('data-anggota');
Route::get('/dashboard/golongan-counts', [DashboardController::class, 'golonganCounts']);
Route::get('/dashboard/events', [DashboardController::class, 'dashboardEvents']);
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/anggota/create', [AnggotaController::class, 'create'])->name('anggota.create');
    Route::post('/anggota', [AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('/anggota/{nomor_anggota}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');
    Route::put('/anggota/{nomor_anggota}', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('/anggota/{nomor_anggota}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');
    Route::post('/anggota/import', [AnggotaController::class, 'import'])->name('anggota.import');
    Route::get('/anggota/golongan-pramuka', [AnggotaController::class, 'getGolonganPramuka']);
    Route::get('/kenaikan', [KenaikanGolonganController::class, 'index'])->name('kenaikan');
    Route::post('/kenaikan', [KenaikanGolonganController::class, 'store'])->name('kenaikan.store');
    Route::get('/anggota/{nomor_anggota}/kta', [AnggotaController::class, 'showKta']);
});

Route::get('/jadwal-event', [EventsController::class, 'index'])->name('jadwal-event');
Route::get('/events', [EventsController::class, 'getEvents'])->name('event');
Route::get('/events/create', [EventsController::class, 'create'])->name('event.create');
Route::post('/events', [EventsController::class, 'store'])->name('event.store');
Route::get('/events/{id}/edit', [EventsController::class, 'edit'])->name('event.edit');
Route::put('/events/{id}', [EventsController::class, 'update'])->name('event.update');
Route::delete('/events', [EventsController::class, 'destroy'])->name('event.destroy');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
