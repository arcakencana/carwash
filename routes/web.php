<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/register', function () {
    return redirect('/login');
});

//Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);


Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->name('dashboard');

    Route::get('/api/dashboard/harian', [App\Http\Controllers\DashboardController::class, 'grafikHarian']);

    //profile
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])
    ->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])
    ->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])
    ->name('profile.destroy');

    Route::get('/get-kelurahan/{kecamatan_id}', [App\Http\Controllers\WilayahController::class, 'getKelurahan'])
    ->name('getKelurahan');

    // Route::middleware('role:dashboard')->group(function () {
    //     //
    // });

    Route::middleware('role:daftar-kegiatan')->group(function () {

        Route::get('/daftar-kegiatan', [App\Http\Controllers\DaftarKegiatanController::class, 'index'])
        ->name('daftar-kegiatan');

    });

    Route::middleware('role:pendaftaran')->group(function () {

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
        Route::get('/pendaftaran/download/{id}', [App\Http\Controllers\PendaftaranController::class, 'download'])
        ->name('pendaftaran.download');

        Route::get('/pendaftaran-khusus/{id}', [App\Http\Controllers\PendaftaranKhususController::class, 'create'])
        ->name('pendaftaran-khusus.create');
        Route::post('/pendaftaran-khusus/{id}', [App\Http\Controllers\PendaftaranKhususController::class, 'store'])
        ->name('pendaftaran-khusus.store');



    });

    Route::middleware('role:verifikasi')->group(function () {

        Route::get('/verifikasi/{id}', [App\Http\Controllers\VerifikasiController::class, 'show'])
        ->name('verifikasi.show');

        Route::put('/verifikasi/{id}', [App\Http\Controllers\VerifikasiController::class, 'update'])
        ->name('verifikasi.update');

    });

    Route::middleware('role:kegiatan')->group(function () {

        Route::resource('kegiatan', App\Http\Controllers\KegiatanController::class);
        Route::get('/kegiatan/kuota/{id}', [App\Http\Controllers\KegiatanController::class, 'kuota'])
        ->name('kegiatan.kuota');
        Route::put('/kegiatan/kuota/update-massal', [App\Http\Controllers\KegiatanController::class, 'kuotaUpdateMassal'])
        ->name('kuota.updateMassal');
        Route::get('/kegiatan/pdf/{id}', [App\Http\Controllers\KegiatanController::class, 'exportPdf'])
        ->name('kegiatan.pdf');

    });

    Route::middleware('role:admin')->group(function () {

        //user
        Route::resource('users', App\Http\Controllers\UserController::class);
        Route::resource('roles', App\Http\Controllers\RoleController::class);

        // Assign Role
        Route::get('/users/{user}/assign-role', [App\Http\Controllers\UserController::class, 'assignRole'])
        ->name('users.assignRole');
        Route::post('/users/{user}/assign-role', [App\Http\Controllers\UserController::class, 'storeAssignedRole'])
        ->name('users.storeAssignedRole');

    });


});

require __DIR__ . '/auth.php';
