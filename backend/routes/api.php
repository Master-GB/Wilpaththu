<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\Api\JeepController;
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
    Route::patch('/businesses/{business}/active', [BusinessController::class, 'updateActive']);
    Route::patch('/businesses/{business}/verify', [BusinessController::class, 'verify']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/jeeps', [JeepController::class, 'index']);
    Route::get('/jeeps/{jeep}', [JeepController::class, 'show']);
    Route::post('/jeeps', [JeepController::class, 'store']);
    Route::put('/jeeps/{jeep}', [JeepController::class, 'update']);
    Route::delete('/jeeps/{jeep}', [JeepController::class, 'destroy']);

    Route::patch('jeeps/{jeep}/assign-driver',[JeepController::class, 'assignJeepDriver']);
    Route::patch('jeeps/{jeep}/remove-driver',[JeepController::class, 'removeJeepDriver']);
    Route::patch('jeeps/{jeep}/change-status',[JeepController::class, 'changeJeepStatus']);

});
