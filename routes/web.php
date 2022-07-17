<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\invoicesArchive;

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
   return redirect('/home');
});

Auth::routes();
//
Route::group(['middleware' => ['auth']], function() {
    // profil route
    Route::post('profil/setimg',[App\Http\Controllers\ProfilController::class,'set_img'])->name('profil.set_img');
    Route::post('profil/store',[App\Http\Controllers\ProfilController::class,'store'])->name('profil.setting');
    Route::get('profil',[App\Http\Controllers\ProfilController::class,'index'])->name('profil');

    Route::resource('roles','App\Http\Controllers\RoleController');
    Route::resource('users','App\Http\Controllers\UserController');
    Route::resource('invoices', InvoicesController::class);
    Route::resource('sections', SectionsController::class);
    Route::resource('products', ProductsController::class);
    Route::resource('archive', invoicesArchive::class);
    Route::resource('attachments', InvoiceAttachmentsController::class);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('markAsread_all/{id}', [App\Http\Controllers\HomeController::class, 'markAsread'])->name('markAsread');
    Route::post('/markAsread_all', [App\Http\Controllers\HomeController::class, 'markAsread_all'])->name('markAsread_all');

    Route::get('print-invoice/{id}','App\Http\Controllers\InvoicesController@print')->name('print.invoices');

    Route::get('section/{id}','App\Http\Controllers\InvoicesController@getproducts')->name('getproducts');
// invoices padding
    Route::get('invoices-paid/{id}','App\Http\Controllers\InvoicesController@paidding')->name('paidding');
//
    Route::post('customer-reports','App\Http\Controllers\CustomerReport@search_invoices')->name('customer.search');
    Route::get('customer-reports','App\Http\Controllers\CustomerReport@index')->name('customer.report');
    Route::post('reports','App\Http\Controllers\invoicesreports@search_invoices')->name('report.search');
    Route::get('reports','App\Http\Controllers\invoicesreports@index')->name('report');
    Route::get('invoicesdetalis/{id}','App\Http\Controllers\InvoicesDetailsController@edit')->name('invoicesdetalis');
    Route::get('viewfile/{invoices_numper}/{file_name}','App\Http\Controllers\InvoicesDetailsController@openfile')->name('openfile');
    Route::get('download/{invoices_numper}/{file_name}','App\Http\Controllers\InvoicesDetailsController@download')->name('download');
    Route::delete('delete-file','App\Http\Controllers\InvoicesDetailsController@destroy')->name('delete.file');
    Route::put('invoices/{id}/statusupdate/','App\Http\Controllers\InvoicesController@status_update')->name('status_update');
    });


// Route::get('/{page}', 'App\Http\Controllers\AdminController@index')->middleware('auth');

