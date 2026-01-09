<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('{id}', [UserController::class, 'show']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('{id}', [UserController::class, 'update']);
        Route::delete('{id}', [UserController::class, 'destroy']);
    });

    Route::prefix('agencies')->group(function () {
        Route::get('/', [AgencyController::class, 'index']);
        Route::get('{id}', [AgencyController::class, 'show']);
        Route::post('/', [AgencyController::class, 'store']);
        Route::put('{id}', [AgencyController::class, 'update']);
        Route::delete('{id}', [AgencyController::class, 'destroy']);
    });
});
