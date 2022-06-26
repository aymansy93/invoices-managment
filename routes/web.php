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
    return view('auth.login');
});

Auth::routes();

Route::resource('invoices', InvoicesController::class)->middleware('auth');
Route::resource('sections', SectionsController::class)->middleware('auth');
Route::resource('products', ProductsController::class)->middleware('auth');
Route::resource('archive', invoicesArchive::class)->middleware('auth');
Route::resource('attachments', InvoiceAttachmentsController::class)->middleware('auth');
Route::get('print-invoice/{id}','App\Http\Controllers\InvoicesController@print')->name('print.invoices')->middleware('auth');

Route::get('section/{id}','App\Http\Controllers\InvoicesController@getproducts')->name('getproducts')->middleware('auth');
// invoices padding
Route::get('invoices-paid/{id}','App\Http\Controllers\InvoicesController@paidding')->name('paidding')->middleware('auth');
//
Route::get('invoicesdetalis/{id}','App\Http\Controllers\InvoicesDetailsController@edit')->name('invoicesdetalis')->middleware('auth');
Route::get('viewfile/{invoices_numper}/{file_name}','App\Http\Controllers\InvoicesDetailsController@openfile')->name('openfile')->middleware('auth');
Route::get('download/{invoices_numper}/{file_name}','App\Http\Controllers\InvoicesDetailsController@download')->name('download')->middleware('auth');
Route::delete('delete-file','App\Http\Controllers\InvoicesDetailsController@destroy')->name('delete.file')->middleware('auth');
Route::put('invoices/{id}/statusupdate/','App\Http\Controllers\InvoicesController@status_update')->name('status_update')->middleware('auth');
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','App\Http\Controllers\RoleController');
    Route::resource('users','App\Http\Controllers\UserController');
    });


Route::get('/{page}', 'App\Http\Controllers\AdminController@index')->middleware('auth');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
