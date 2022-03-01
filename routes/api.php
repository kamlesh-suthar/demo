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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => 'v1'], function () {
    Route::post('login', [\App\Http\Controllers\Api\V1\LoginController::class, 'index'])->name('api-login');
//    Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('auth:api')->group(function () {
        Route::post('user', [\App\Http\Controllers\Api\V1\LoginController::class, 'user'])->name('api-user');
        Route::post('logout', [\App\Http\Controllers\Api\V1\LoginController::class, 'logout'])->name('api-logout');
    });
});
