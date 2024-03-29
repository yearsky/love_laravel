<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PrediksiController;
use App\Http\Controllers\UserController;

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

Route::get('/', [AuthenticatedSessionController::class, 'create']);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/user', [ProfileController::class, 'edit'])->name('profile.user');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Barang Controller
    Route::get('/barang', [BarangController::class, 'index'])->name('barang');
    Route::get('/barang/{id}', [BarangController::class, 'show'])->name('barang.show');
    Route::get('/barang/edit/{id}', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/barang', [BarangController::class, 'createOrUpdate'])->name('barang.createOrUpdate');
    Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');

    //Prediksi Controller
    Route::get('/prediksi', [PrediksiController::class, 'index'])->name('prediksi');
    // Route::get('/prediksi', [PrediksiController::class, 'olah'])->name('prediksi.olah');

    Route::get('/kelolauser', [UserController::class, 'index'])->name('kelolauser');
    Route::get('/add-user', [UserController::class, 'add'])->name('kelolauser.add');
    Route::post('/add-user', [UserController::class, 'save'])->name('kelolauser.save');
    Route::get('/kelolauser/{id}', [UserController::class, 'edit'])->name('kelolauser.edit');
    Route::patch('/kelolauser/{id}', [UserController::class, 'update'])->name('kelolauser.update');
    Route::delete('/kelolauser/{id}', [UserController::class, 'destroy'])->name('kelolauser.delete');
});

require __DIR__ . '/auth.php';
