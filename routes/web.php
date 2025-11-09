<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/pendaftaran/{id}', [App\Http\Controllers\PendaftaranController::class, 'create'])->name('pendaftaran.create');
Route::post('/pendaftaran/{id}', [App\Http\Controllers\PendaftaranController::class, 'store'])->name('pendaftaran.store');
Route::get('/pendaftaran/download/{id}', [App\Http\Controllers\PendaftaranController::class, 'download'])->name('pendaftaran.download');

Route::get('/get-kuota/{kegiatan_id}/{kecamatan_id}', [App\Http\Controllers\PendaftaranController::class, 'getKuota'])
->name('getKuota');
Route::get('/get-kelurahan/{kecamatan_id}', [App\Http\Controllers\WilayahController::class, 'getKelurahan']);

Route::get('/register', function () {
    return redirect('/login');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
->middleware(['auth'])
->name('dashboard');

// profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

// CRUD hanya untuk admin
Route::group(['middleware' => ['auth','role:admin']], function () {
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('kegiatan', App\Http\Controllers\KegiatanController::class);
    Route::get('/kegiatan/pdf/{id}', [App\Http\Controllers\KegiatanController::class, 'exportPdf'])->name('kegiatan.pdf');
    Route::get('/kegiatan/kuota/{id}', [App\Http\Controllers\KegiatanController::class, 'kuota'])->name('kegiatan.kuota');
    Route::put('/kegiatan/kuota/update-massal', [App\Http\Controllers\KegiatanController::class, 'kuotaUpdateMassal'])->name('kuota.updateMassal');

    Route::get('/pendaftaran-khusus/{id}', [App\Http\Controllers\PendaftaranKhususController::class, 'create'])->name('pendaftaran-khusus.create');
    Route::post('/pendaftaran-khusus/{id}', [App\Http\Controllers\PendaftaranKhususController::class, 'store'])->name('pendaftaran-khusus.store');
});

// CRUD hanya untuk user
Route::group(['middleware' => ['auth','role:user']], function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
});

require __DIR__.'/auth.php';
