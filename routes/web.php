<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    UserController,
    CategoryUsersController,
    YayasanController,

};
use App\Http\Controllers\Penduduk\{
    CategeoryPendudukController,
    PendudukController,
    ReportController,
};

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

Route::get('/', function () {
    return view('dashboard');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/user', UserController::class);

Route::resource('/category_pr', CategeoryPendudukController::class);

Route::resource('/category_users', CategoryUsersController::class);

// route penduduk rentan
Route::resource('/penduduk', PendudukController::class);
Route::get('/all_pr', [PendudukController::class,'all_pr']);
Route::get('/list_napi', [PendudukController::class,'list_napi']); //just url
// Route::get('/list_napi', [PendudukController::class,'list_napi'])->name('list_napi'); //url and route
// Route::get('/list_napi', [App\Http\Controllers\Penduduk\PendudukController::class, 'list_napi'])->name('list_napi');
Route::get('/list_transgender', [PendudukController::class,'list_transgender']);
Route::get('/list_odgj', [PendudukController::class,'list_odgj']);
Route::get('/list_panti_asuhan', [PendudukController::class,'list_panti_asuhan']);

// routes yayasan
Route::resource('/yayasan', YayasanController::class);
Route::get('/yayasan_odgj', [YayasanController::class,'yayasan_odgj']);
Route::get('/yayasan_p_asuhan', [YayasanController::class,'yayasan_p_asuhan']);

// routes report
Route::get('/download_lampiran/{id}', [ReportController::class, 'download_lampiran'])->name('download.lampiran');
Route::post('/import_penduduk', [ReportController::class, 'import_penduduk'])->name('import.penduduk');
Route::get('/penduduk_excel', [ReportController::class, 'export_excel'])->name('penduduk.excel');
Route::get('/disablitas_excel', [ReportController::class, 'disablitas_excel'])->name('disablitas.excel');
Route::get('/napi_excel', [ReportController::class, 'napi_excel'])->name('napi.excel');
Route::get('/transgender_excel', [ReportController::class, 'transgender_excel'])->name('transgender.excel');
Route::get('/odgj_excel', [ReportController::class, 'odgj_excel'])->name('odgj.excel');
Route::get('/panti_asuhan_excel', [ReportController::class, 'panti_asuhan_excel'])->name('panti_asuhan.excel');

