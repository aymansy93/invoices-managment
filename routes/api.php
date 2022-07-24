<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
    Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);
    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::post('/refresh', [App\Http\Controllers\Api\AuthController::class, 'refresh']);
    Route::get('/user-profile', [App\Http\Controllers\Api\AuthController::class, 'userProfile']);
});
//

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['jwt.mid']], function() {
    Route::get('invoices',[App\Http\Controllers\Api\ApiinvoicesController::class,'index']);
    Route::get('invoices/{id}',[App\Http\Controllers\Api\ApiinvoicesController::class,'show']);
    Route::post('invoices',[App\Http\Controllers\Api\ApiinvoicesController::class,'store']);
    Route::put('invoices/{id}',[App\Http\Controllers\Api\ApiinvoicesController::class,'update']);
    Route::delete('invoices/{id}',[App\Http\Controllers\Api\ApiinvoicesController::class,'distroy']);
});
