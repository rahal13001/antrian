<?php

use App\Http\Controllers\ServicesController;
use App\Http\Controllers\VisitorsController;
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
Route::get('/sorong', [VisitorsController::class, 'sorong'])->name('display_sorong');
Route::get('/merauke', [VisitorsController::class, 'merauke'])->name('display_merauke');
Route::get('/ambon', [VisitorsController::class, 'ambon'])->name('display_ambon');
Route::get('/ternate', [VisitorsController::class, 'ternate'])->name('display_ternate');
Route::get('/morotai', [VisitorsController::class, 'morotai'])->name('display_morotai');


//status ada atau ga pengantrinya
Route::put('/status/{status}', [VisitorsController::class, 'status'])->name('status_update');

//autentikasi jadi ga bisa reset password dan register (mengamankan admin)
Auth::routes(['register' => false, 'reset' => false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
