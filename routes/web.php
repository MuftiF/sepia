<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PersonalisasiController;
use App\Http\Controllers\ForecastingController;
use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\GroqProxyController;


Route::get('/', [HomeController::class, 'index'])->name('home');

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth','verified'])->name('dashboard');




Route::middleware(['auth'])->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class,'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class,'destroy'])->name('profile.destroy');

    // Laporan
   Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
   Route::post('/laporan/store', [LaporanController::class, 'store'])->name('laporan.store');

    // Analisis
    Route::get('/analisis', [AnalisisController::class,'index'])->name('analisis.index');
    Route::get('/analisis/{id}', [AnalisisController::class,'show'])->name('analisis.show');

    // Forecasting
    Route::get('/forecasting', [ForecastingController::class,'index'])->name('forecasting.index');

    // Personalisasi
    Route::get('/personalisasi', [PersonalisasiController::class,'index'])->name('personalisasi.index');

});






Route::post('/api/groq/chat', [GroqProxyController::class,'chat'])->name('groq.chat');


require __DIR__.'/auth.php';