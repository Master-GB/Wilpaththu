<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\BusinessController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', [AuthController::class, 'user']);

});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('businesses', BusinessController::class);

    Route::get('/businesses', [BusinessController::class, 'index']);
Route::get('/businesses/{business}', [BusinessController::class, 'show']);
Route::post('/businesses', [BusinessController::class, 'store']);
Route::put('/businesses/{business}', [BusinessController::class, 'update']);
    Route::delete('/businesses/{business}', [BusinessController::class, 'destroy']);
    Route::post('/businesses/{business}/verify', [BusinessController::class, 'verify']);
});
