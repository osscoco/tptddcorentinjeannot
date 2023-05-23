<?php

use App\Http\Controllers\AuthentificationController;
use App\Http\Controllers\BookController;
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
Route::middleware('json.in.headers')->group(function () {

    Route::post('/login', [AuthentificationController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/user', [AuthentificationController::class, 'user']);
        Route::get('/logout', [AuthentificationController::class, 'logout']);

        Route::middleware('admin')->group(function () {

            Route::post('/book/store', [BookController::class, 'store']);
        });
    });
});
