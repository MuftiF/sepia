<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PersonalisasiController;
use App\Http\Controllers\ForecastingController;
use App\Http\Controllers\AnalisisController;

/*
|--------------------------------------------------------------------------
| SEPIA — Web Routes
| File: routes/web.php
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Laporan
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

// Personalisasi
Route::get('/personalisasi', [PersonalisasiController::class, 'index'])->name('personalisasi.index');

// Forecasting
Route::get('/forecasting', [ForecastingController::class, 'index'])->name('forecasting.index');

// Analisis (coming soon)
Route::get('/analisis', [AnalisisController::class, 'index'])->name('analisis.index');


use App\Http\Controllers\GroqProxyController;
Route::post('/api/groq/chat', [GroqProxyController::class, 'chat'])->name('groq.chat');

require __DIR__.'/auth.php';
