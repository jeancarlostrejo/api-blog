<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SubscriptionController;
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
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/posts/{post}/likes', [LikeController::class, 'store'])->name('post.like');
    Route::post('/users/{user}/subscribe', [SubscriptionController::class, 'subscribe'])->name('users.subscribe');
    Route::delete('/users/{user}/unsubscribe', [SubscriptionController::class, 'unsubscribe'])->name('users.unsubscribe');
});