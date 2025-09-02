<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RumahSakitController;
use App\Http\Controllers\PasienController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rumah Sakit routes
    Route::resource('rumah-sakits', RumahSakitController::class);
    Route::get('/api/rumah-sakits', [RumahSakitController::class, 'getRumahSakits'])->name('api.rumah-sakits');

    // Pasien routes
    Route::resource('pasiens', PasienController::class);
    Route::get('/api/pasiens/filter', [PasienController::class, 'filterByRumahSakit'])->name('api.pasiens.filter');
});

require __DIR__ . '/auth.php';
