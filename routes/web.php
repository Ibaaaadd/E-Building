<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GedungController;
use App\Http\Controllers\AspekController;
use App\Http\Controllers\IndikatorController;
use App\Http\Controllers\PelaporanController;
use App\Http\Controllers\DetailPenilaianController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DinasController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\SektorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\LandingController;

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

Route::get('/', function() {
    return redirect()->route('beranda');
});
Route::get('/beranda', [LandingController::class, 'index'])->name('beranda');
Route::get('/beranda/sektor/{id}', [LandingController::class, 'sektor'])->name('beranda.sektor');
Route::get('/beranda/jenis/{id}', [LandingController::class, 'jenis'])->name('beranda.jenis');
Route::get('/beranda/gedung/{id}', [LandingController::class, 'gedung'])->name('beranda.gedung');


Auth::routes();

Route::resource('sektor', SektorController::class);

Route::resource('jenis', JenisController::class);

Route::resource('gedung', GedungController::class);

Route::resource('pelaporan', PelaporanController::class);

Route::resource('dinas', DinasController::class);

// Route::get('/landing-sektor', [LandingController::class, 'sektor'])->name('landing.sektor');

// Route::get('/landing-jenis', [LandingController::class, 'jenis'])->name('landing.jenis');

// Route::get('/landing-detail', [LandingController::class, 'detail'])->name('landing.detail');



// Untuk semua peran (role)
Route::group(['middleware' => ['auth']], function () {

    Route::patch('/detail/{id}/updateStatus', [DetailController::class, 'updateStatus'])->name('detail.updateStatus');

    Route::get('/detail/{id}', [DetailController::class, 'index'])->name('detail.index');

    Route::post('/detail/{id}', [DetailController::class, 'store'])->name('detail.store');

    Route::put('/detail/{id}', [DetailController::class, 'update'])->name('detail.update');
    
    Route::delete('/detail/{id}', [DetailController::class, 'destroy'])->name('detail.destroy');

    Route::get('/detail-penilaian', [DetailPenilaianController::class, 'index'])->name('detailPenilaian.index');

    Route::post('/penilaian-simpan/{id}', [App\Http\Controllers\DetailPenilaianController::class, 'simpan'])->name('penilaian.simpan');

    Route::get('/penilaian/{id}', [App\Http\Controllers\DetailPenilaianController::class, 'index'])->name('penilaian.index');

    Route::get('/penilaian-detail/{id}', [App\Http\Controllers\DetailPenilaianController::class, 'detail'])->name('penilaian.detail');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::group(['middleware' => ['checkrole:4']], function () {
        //Route::get('/pelapor', [PelaporController::class, 'index']);
    });

    Route::group(['middleware' => ['checkrole:3']], function () {
        Route::put('/detail-penilaian/{id}/upload', [DetailPenilaianController::class, 'upload'])->name('detailPenilaian.upload');

        Route::put('detailPenilaian/{id}', [DetailPenilaianController::class, 'update'])->name('detailPenilaian.update');
    });

    Route::group(['middleware' => ['checkrole:1']], function () {
        Route::resource('aspek', AspekController::class);
        Route::resource('indikator', IndikatorController::class);
        Route::get('/users', [UserController::class, 'index'])->name('user.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/users/create', [UserController::class, 'store'])->name('user.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::get('/users/{id}', [UserController::class, 'show'])->name('user.show');
        Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('user.restore');
    });

    Route::group(['middleware' => ['checkrole:2']], function () {
        Route::put('/detail-penilaian/{id}/ganti', [DetailPenilaianController::class, 'ganti'])->name('detailPenilaian.ganti');
    });
});


