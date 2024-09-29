<?php

use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\CategoryController;
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


Route::prefix('v1')->group(function () {

    Route::post('/login', [UserController::class, 'login'])->name('login');

    Route::resource('posts', PostController::class)->middleware(
        "auth:sanctum"
    );
    Route::middleware('auth:sanctum')->get(
        '/post/{slug}',
        [PostController::class, 'singlePost']
    );

    Route::resource('users', UserController::class)->middleware(
        "auth:sanctum"
    );

    Route::resource('categories', CategoryController::class)->middleware(
        'auth:sanctum'
    );
});

