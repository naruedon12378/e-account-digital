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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Check Email
Route::post('/checkEmail', [App\Http\Controllers\APIs\ApiController::class, 'checkEmail'])->name('api.check.email');


//Check Username
Route::post('/checkUsername', [App\Http\Controllers\APIs\ApiController::class, 'checkUsername'])->name('api.check.username');

// Google Analytics
Route::post('/analytics', [App\Http\Controllers\APIs\ApiController::class, 'getdataGoogleAnalytics'])->name('analytics');
