<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\HomeController;
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

Route::group(['namespace' => 'Api', 'prefix' => 'v1',], function () {
    
    Route::post('login', [AuthenticationController::class, 'store'])->name('login');
    Route::post('signup', [AuthenticationController::class, 'signup'])->name('signup');
    Route::post('check_email', [AuthenticationController::class, 'check_email']);
});

Route::group(['namespace' => 'Api', 'prefix' => 'v1', 'middleware' => ['json.response', 'auth:api']], function () {
    Route::post('home', [HomeController::class, 'index'])->name('home');
    Route::post('create_order', [HomeController::class, 'create_order'])->name('create_order');
});
