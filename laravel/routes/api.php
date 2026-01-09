<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ParticipateController;

// Public auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    // Users CRUD
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);

        // 1. lekérdezés (VIP listázás) – ide került, hogy ne ütközzön a /users/{id}-vel
        Route::get('/vip', [UserController::class, 'vipUsers']);
    });

    // Agencies CRUD
    Route::prefix('agencies')->group(function () {
        Route::get('/', [AgencyController::class, 'index']);
        Route::get('/{id}', [AgencyController::class, 'show']);
        Route::post('/', [AgencyController::class, 'store']);
        Route::put('/{id}', [AgencyController::class, 'update']);
        Route::delete('/{id}', [AgencyController::class, 'destroy']);

        // 4. lekérdezés – ide került, hogy ne ütközzön a /agencies/{id}-vel
        Route::get('/with-two-events', [AgencyController::class, 'agenciesWithAtLeastTwoEvents']);
    });

    // Admins CRUD
    Route::prefix('admins')->group(function () {
        Route::get('/', [AdminController::class, 'index']);
        Route::get('/{id}', [AdminController::class, 'show']);
        Route::post('/', [AdminController::class, 'store']);
        Route::put('/{id}', [AdminController::class, 'update']);
        Route::delete('/{id}', [AdminController::class, 'destroy']);
    });

    // Events extra + (opcionálisan CRUD, ha később kell)
    Route::prefix('events')->group(function () {
        // 3. lekérdezés
        Route::put('/expire-old', [EventController::class, 'expireOldEvents']);

        // 5. lekérdezés
        Route::post('/{event_id}/invite-vip', [EventController::class, 'inviteVipIfHasSpace']);

        // 6. lekérdezés
        Route::put('/{event_id}/postpone-one-week', [EventController::class, 'postponeOneWeek']);
    });

    // Participations extra
    Route::prefix('participations')->group(function () {
        // 2. lekérdezés
        Route::put('/cancel-today', [ParticipateController::class, 'cancelToday']);
    });

});