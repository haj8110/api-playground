<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SwaggerTestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;

Route::get('/test', [SwaggerTestController::class, 'test']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('blogs', BlogController::class);
});


