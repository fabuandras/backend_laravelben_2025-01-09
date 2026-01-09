<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\EventController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

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

Route::get('/users/vip', [UserController::class, 'vipUsers']);

Route::put('/participations/cancel-today', [ParticipateController::class, 'cancelTodayParticipations']);

Route::put('/events/expire-old', [EventController::class, 'expireOldEvents']);

Route::get('/agencies/with-two-events', [AgencyController::class, 'agenciesWithAtLeastTwoEvents']);

Route::post('/events/{event_id}/invite-vip', [EventController::class, 'inviteVipIfHasSpace']);

Route::put('/events/{event_id}/postpone-one-week', [EventController::class, 'postponeOneWeek']);