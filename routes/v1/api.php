<?php

use App\Http\Controllers\Api\v1\Auth\LoginController;
use App\Http\Controllers\Api\V1\FallbackController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/**
 * ===================================================================
 * GUEST ONLY ROUTES
 * ===================================================================
 */

 Route::group(['middleware' => ['guest:api']], function () {
    Route::post('/login', [LoginController::class, 'login'])->name('api.login');
});


/**
 * ===================================================================
 * AUTH ROUTES
 * ===================================================================
 */

 Route::group(['middleware' => ['auth:api']], function () {
    Route::get('users', [LoginController::class, 'getUser'])->name('api.user');
    Route::post('logout', [LoginController::class, 'logout'])->name('api.logout');
 });


 Route::any('{uri}', [FallbackController::class, 'missing'])->where('uri', '.*');
