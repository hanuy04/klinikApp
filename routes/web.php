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
});
