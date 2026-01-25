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

    });

    Route::middleware(['role:admin'])->group(function () {

        Route::resource('master-barang', App\Http\Controllers\MasterBarangController::class);

        Route::get('/pendaftaran/{id}', [App\Http\Controllers\PendaftaranController::class, 'index'])
        ->name('pendaftaran.index');
        Route::get('/pendaftaran/create/{id}', [App\Http\Controllers\PendaftaranController::class, 'create'])
        ->name('pendaftaran.create');
        Route::post('/pendaftaran/{id}', [App\Http\Controllers\PendaftaranController::class, 'store'])
        ->name('pendaftaran.store');
        Route::get('/pendaftaran/edit/{id}', [App\Http\Controllers\PendaftaranController::class, 'edit']);
        Route::put('/pendaftaran/{id}', [App\Http\Controllers\PendaftaranController::class, 'update'])
        ->name('pendaftaran.update');
        Route::delete('/pendaftaran', [App\Http\Controllers\PendaftaranController::class, 'destroy'])
        ->name('pendaftaran.destroy');
        Route::get('/pendaftaran/laporan/{id}', [App\Http\Controllers\PendaftaranController::class, 'laporan']);

    });

});

require __DIR__ . '/auth.php';
