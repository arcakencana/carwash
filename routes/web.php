<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home/{id}', [App\Http\Controllers\HomeController::class, 'show'])->name('home.show');
Route::get('/pendaftaran/{id}', [App\Http\Controllers\PendaftaranController::class, 'create'])->name('pendaftaran.create');
Route::post('/pendaftaran/{id}', [App\Http\Controllers\PendaftaranController::class, 'store'])->name('pendaftaran.store');

Route::get('/register', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['auth','role:admin']], function () {
    // User CRUD hanya untuk admin
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('kegiatan', App\Http\Controllers\KegiatanController::class);
    Route::get('/kegiatan/pdf/{id}', [App\Http\Controllers\KegiatanController::class, 'exportPdf'])->name('kegiatan.pdf');
});

Route::group(['middleware' => ['auth','role:user']], function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
});

require __DIR__.'/auth.php';

