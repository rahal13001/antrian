<?php

use App\Http\Controllers\AktivitasambonController;
use App\Http\Controllers\AktivitasmeraukeController;
use App\Http\Controllers\AktivitasmorotaiController;
use App\Http\Controllers\AktivitassorongController;
use App\Http\Controllers\AktivitasternateController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\VisitorsController;
use App\Http\Controllers\DisplayController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


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
//User
// Route::get('/kartucetak', function () {
//     return view('kartu.kartu');
// });

//untuk yang mau antri
Route::get('/', [VisitorsController::class, 'index'])->name('index');
Route::post('/visitor', [VisitorsController::class, 'store'])->name('vis_store');




//pdf
Route::post('/visitors/exportpdf', [VisitorsController::class, 'exportpdf'])->name('exportpdf');


Route::group(['middleware' => 'auth'], function () {
    //Admin
    Route::get('/dashboard', [ServicesController::class, 'index'])->name('admin_index');
    Route::get('/service/{visitor}/edit', [ServicesController::class, 'edit'])->name('admin_edit');
    Route::get('/service/create', [ServicesController::class, 'create'])->name('admin_create');
    Route::post('/service', [ServicesController::class, 'store'])->name('admin_store');
    Route::put('/service/{visitor}', [ServicesController::class, 'update'])->name('admin_update');
    Route::delete('/service/{visitor}', [ServicesController::class, 'destroy'])->name('admin_delete');
    Route::get('/service/{service}', [ServicesController::class, 'show'])->name('admin_detail');
    //Excel
    Route::get('/visitors/exportexcel', [ServicesController::class, 'exportexcel'])->name('exportexcel');
});

//display masing masing satker
//Pelayanan, pengaduan, konsultasi di Sorong
Route::put('/statussorong/{sorong}', [AktivitassorongController::class, 'status'])->name('status_sorong');
Route::get('/pelayanansorong', [AktivitassorongController::class, 'pelayanan'])->name('pelayanan_sorong');
Route::get('/pengaduansorong', [AktivitassorongController::class, 'pengaduan'])->name('pengaduan_sorong');
Route::get('/konsultasisorong', [AktivitassorongController::class, 'konsultasi'])->name('konsultasi_sorong');

//Pelayanan, pengaduan, konsultasi di Ambon
Route::put('/statusambon/{ambon}', [AktivitasambonController::class, 'status'])->name('status_ambon');
Route::get('/pelayananambon', [AktivitasambonController::class, 'pelayanan'])->name('pelayanan_ambon');
Route::get('/pengaduanambon', [AktivitasambonController::class, 'pengaduan'])->name('pengaduan_ambon');
Route::get('/konsultasiambon', [AktivitasambonController::class, 'konsultasi'])->name('konsultasi_ambon');


//Pelayanan, pengaduan, konsultasi di Merauke
Route::put('/statusmerauke/{merauke}', [AktivitasmeraukeController::class, 'status'])->name('status_merauke');
Route::get('/pelayananmerauke', [AktivitasmeraukeController::class, 'pelayanan'])->name('pelayanan_merauke');
Route::get('/pengaduanmerauke', [AktivitasmeraukeController::class, 'pengaduan'])->name('pengaduan_merauke');
Route::get('/konsultasimerauke', [AktivitasmeraukeController::class, 'konsultasi'])->name('konsultasi_merauke');

//Pelayanan, pengaduan, konsultasi di Ternate
Route::put('/statusternate/{ternate}', [AktivitasternateController::class, 'status'])->name('status_ternate');
Route::get('/pelayananternate', [AktivitasternateController::class, 'pelayanan'])->name('pelayanan_ternate');
Route::get('/pengaduanternate', [AktivitasternateController::class, 'pengaduan'])->name('pengaduan_ternate');
Route::get('/konsultasiternate', [AktivitasternateController::class, 'konsultasi'])->name('konsultasi_ternate');

//
Route::put('/statusmorotai/{morotai}', [AktivitasmorotaiController::class, 'status'])->name('status_morotai');
Route::get('/pelayananmorotai', [AktivitasmorotaiController::class, 'pelayanan'])->name('pelayanan_morotai');
Route::get('/pengaduanmorotai', [AktivitasmorotaiController::class, 'pengaduan'])->name('pengaduan_morotai');
Route::get('/konsultasimorotai', [AktivitasmorotaiController::class, 'konsultasi'])->name('konsultasi_morotai');



//Tampilan grid masing-masing antrian di masing-masing satker
Route::get('/antriansorong', function () {
    return view('pengunjung.displaysorong');
});

Route::get('/antrianambon', function () {
    return view('pengunjung.displayambon');
});

Route::get('/antrianmerauke', function () {
    return view('pengunjung.displaymerauke');
});
Route::get('/antrianternate', function () {
    return view('pengunjung.displayternate');
});
Route::get('/antrianmorotai', function () {
    return view('pengunjung.displaymorotai');
});

//autentikasi jadi ga bisa reset password dan register (mengamankan admin)
Auth::routes(['reset' => false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
