<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    UserController,
    // CategoryUsersController,
    YayasanController,
    EventController,

};
use App\Http\Controllers\Penduduk\{
    // CategeoryPendudukController,
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
    return view('auth.login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {

	Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

	Route::resource('/user', UserController::class);

	// remove featur category
	// Route::resource('/category_pr', CategeoryPendudukController::class);
	// Route::resource('/category_users', CategoryUsersController::class);

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
	Route::get('/event_pdf/{id}', [ReportController::class, 'event_pdf'])->name('event.pdf');
	Route::get('/download_nota_dinas/{id}', [ReportController::class, 'download_nota_dinas'])->name('download.nota_lampiran');
	Route::get('/detail_pr_pdf/{id}', [ReportController::class, 'detail_pr_pdf'])->name('detail_pr.pdf');

	Route::get('/all_pr_pdf', [ReportController::class, 'all_pr_pdf'])->name('all_pr.pdf');
	Route::get('/disabilitas_pdf', [ReportController::class, 'disabilitas_pdf'])->name('disablitas.pdf');
	Route::get('/napi_pdf', [ReportController::class, 'napi_pdf'])->name('napi.pdf');
	Route::get('/transgender_pdf', [ReportController::class, 'transgender_pdf'])->name('transgender.pdf');
	Route::get('/odgj_pdf', [ReportController::class, 'odgj_pdf'])->name('odgj.pdf');
	Route::get('/panti_asuhans_pdf', [ReportController::class, 'panti_asuhans_pdf'])->name('panti_asuhans.pdf');
	Route::get('/yayasan_pdf', [ReportController::class, 'yayasan_pdf'])->name('yayasan.pdf');

	// route events
	Route::resource('/event', EventController::class);
	Route::get('/event_internal', [EventController::class, 'event_internal'])->name('event.internal');
	Route::get('/create_event_internal', [EventController::class, 'create_event_internal'])->name('create_event.internal');
	Route::post('/store_event_internal', [EventController::class, 'store_event_internal'])->name('store_event.internal');
	Route::get('/edit_event_internal/{id}', [EventController::class, 'edit_event_internal'])->name('edit_event.internal');
});
