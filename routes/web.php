<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/register', function () {
    return redirect('/login');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->name('dashboard');

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])
    ->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])
    ->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])
    ->name('profile.destroy');

    Route::middleware(['role:user'])->group(function () {

        Route::resource('transaksi', App\Http\Controllers\TransaksiController::class);

    });

    Route::middleware(['role:kasir'])->group(function () {

        Route::resource('data-transaksi', App\Http\Controllers\DataTransaksiController::class);
        Route::post('data-transaksi/{transaksi}/bayar', [App\Http\Controllers\DataTransaksiController::class, 'bayar'])->name('data-transaksi.bayar');


    });

    Route::middleware(['role:admin'])->group(function () {

        Route::resource('master-barang', App\Http\Controllers\MasterBarangController::class);

    });

});

require __DIR__ . '/auth.php';
