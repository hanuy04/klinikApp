<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// login admin/dokter
Route::get('/login', [MainController::class, 'showLoginPage'])->name('login');
Route::post('/login', [MainController::class, 'doLogin'])->name('login.submit');

// logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');


// route untuk admin
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'showDashboard'])->name('admin.dashboard');
    Route::get('/view/poli', [AdminController::class, 'showPoli'])->name('admin.poli');
    Route::get('/view/dokter', [AdminController::class, 'showDokter'])->name('admin.dokter');
    Route::get('/view/pasien', [AdminController::class, 'showPasien'])->name('admin.pasien');

    // crud poli
    // Route::get('/poli/create', [AdminController::class, 'createPoli'])->name('admin.poli.create');
    // Route::post('/poli/create', [AdminController::class, 'storePoli'])->name('admin.poli.store');
    Route::get('/view/poli/edit/{id}', [AdminController::class, 'editPoli'])->name('admin.poli.edit');
    Route::put('/view/poli/edit/{id}', [AdminController::class, 'updatePoli'])->name('admin.poli.update');
    Route::delete('/poli/delete/{id}', [AdminController::class, 'hapusPoli'])->name('admin.poli.hapus');

    // crud dokter
    // Route::get('/dokter/create', [AdminController::class, 'createDokter'])->name('admin.dokter.create');
    // Route::post('/dokter/create', [AdminController::class, 'storeDokter'])->name('admin.dokter.store');
    Route::get('/view/dokter/edit/{id}', [AdminController::class, 'editDokter'])->name('admin.dokter.edit');
    Route::put('/view/dokter/edit/{id}', [AdminController::class, 'updateDokter'])->name('admin.dokter.update');
    Route::delete('/dokter/delete/{id}', [AdminController::class, 'hapusDokter'])->name('admin.dokter.hapus');

    // crud pasien
    // Route::get('/pasien/create', [AdminController::class, 'createPasien'])->name('admin.pasien.create');
    // Route::post('/pasien/create', [AdminController::class, 'storePasien'])->name('admin.pasien.store');
    Route::get('/view/pasien/edit/{id}', [AdminController::class, 'editPasien'])->name('admin.pasien.edit');
    Route::put('/view/pasien/edit/{id}', [AdminController::class, 'updatePasien'])->name('admin.pasien.update');
    Route::delete('/pasien/delete/{id}', [AdminController::class, 'hapusPasien'])->name('admin.pasien.hapus');
});

Route::prefix('pasien')->middleware(['auth', 'role:pasien'])->group(function () {
    Route::get('/pilih-poli', [PendaftaranController::class, 'pilihPoli'])->name('pilih.poli');
    Route::post('/pilih-poli', [PendaftaranController::class, 'prosesPilihPoli'])->name('proses.pilih.poli');
    Route::get('/pilih-dokter/{poliId}', [PendaftaranController::class, 'pilihDokter'])->name('pilih.dokter');
    Route::post('/pilih-dokter', [PendaftaranController::class, 'prosesPilihDokter'])->name('proses.pilih.dokter');
    Route::get('/nomor-antrian/{id}', [PendaftaranController::class, 'nomorAntrian'])->name('nomor.antrian');
});