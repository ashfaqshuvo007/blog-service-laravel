<?php

use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\UserController;
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

Route::post('/login', [UserController::class, 'login']);

Route::prefix('v1')->group(function () {
    Route::resource('posts', PostController::class)->middleware("auth:sanctum");
    Route::get('/post/{slug}', [PostController::class, 'singlePost'])->middleware("auth:sanctum");

    Route::resource('users', UserController::class)->middleware("auth:sanctum");
});
