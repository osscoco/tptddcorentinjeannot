<?php

use App\Http\Controllers\AuthentificationController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenerateDataController;
use App\Http\Controllers\SwaggerController;
use App\Http\Controllers\UngenerateDataController;
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
    Route::get('/swagger/generate', [SwaggerController::class, 'generate']);
    Route::get('/generate-data', [GenerateDataController::class, 'index']);
    Route::get('/ungenerate-data', [UnGenerateDataController::class, 'index']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/user', [AuthentificationController::class, 'user']);
        Route::get('/logout', [AuthentificationController::class, 'logout']);
        Route::get('/books', [BookController::class, 'index']);
        Route::get('/book/show/{id}', [BookController::class, 'show']);

        Route::middleware('admin')->group(function () {

            Route::post('/register', [AuthentificationController::class, 'register']);
            Route::post('/book/store', [BookController::class, 'store']);
            Route::put('/book/update/{id}', [BookController::class, 'update']);
            Route::delete('/book/delete/{id}', [BookController::class, 'destroy']);
        });
    });
});
