<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/register',  'register')->name('register');
    Route::post('/login',  'login')->name('login');
    Route::post('/logout',  'logout')->middleware('auth:sanctum')->name('logout');
});


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/posts', PostController::class);
});