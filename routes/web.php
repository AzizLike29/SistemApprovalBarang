<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\auth\AccountController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Pages\DashboardController;
use App\Http\Controllers\Pages\KelolaBarangController;
use App\Http\Controllers\Pages\HistoryBarangController;
use App\Http\Controllers\Pages\KelolaBarangKeluarController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', fn() => redirect()->route('register'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.action');
    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.action');
});

Route::prefix('barang-masuk')->name('barang-masuk.')->group(function () {
    Route::get('/', [KelolaBarangController::class, 'showBarangMasuk'])->name('index');
    Route::post('/tambah', [KelolaBarangController::class, 'store'])->name('store');
    Route::put('/update/{id_brg_masuk}', [KelolaBarangController::class, 'update'])
        ->name('update');
    Route::delete('/delete/{id_brg_masuk}', [KelolaBarangController::class, 'destroy'])->name('destroy');
    Route::put('/approve/{id_brg_masuk}', [KelolaBarangController::class, 'approve'])
        ->name('approve')
        ->middleware('auth');
    Route::put('/tidak-approve/{id_brg_masuk}', [KelolaBarangController::class, 'notApprove'])
        ->name('notApprove')
        ->middleware('auth');
});

Route::prefix('barang-keluar')->name('barang-keluar.')->group(function () {
    Route::get('/', [KelolaBarangKeluarController::class, 'showBarangKeluar'])->name('index');
    Route::post('/tambah', [KelolaBarangKeluarController::class, 'store'])->name('store');
    Route::delete('/delete/{id_brg_keluar}', [KelolaBarangKeluarController::class, 'destroy'])->name('destroy');
    Route::put('/update/{id_brg_keluar}', [KelolaBarangKeluarController::class, 'update'])
        ->name('update');
    Route::put('/approve/{id_brg_keluar}', [KelolaBarangKeluarController::class, 'approve'])
        ->name('approve')
        ->middleware('auth');
    Route::put('/tidak-approve/{id_brg_keluar}', [KelolaBarangKeluarController::class, 'notApprove'])
        ->name('notApprove')
        ->middleware('auth');
});

Route::get('/history-barang', [HistoryBarangController::class, 'historyBarang'])->name('historyBarang');

Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');

Route::get('/history/download/pdf', [HistoryBarangController::class, 'exportPdf'])
    ->name('history.download.pdf');

Route::middleware('auth')->group(function () {
    Route::get('/account-user', [AccountController::class, 'showAccountForm'])->name('accountForm');
    Route::put('/account/{id}', [AccountController::class, 'editAccount'])->name('account.edit');
});

Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');
