<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\UserController;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

// auth
Route::prefix('v1/auth')->group(function(){
    // auth
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('ping', [AuthController::class, 'ping']);
});

// secure
Route::middleware(['jwt.auth'])->prefix('v1')->group(function(){
    // refresh
    Route::post('refresh-token', [AuthController::class, 'refreshToken']);

    // users
    Route::resource('users', UserController::class);
});
