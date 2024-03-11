<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CatalogoController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('activate/{user}', [AuthController::class, 'activate'])->name('activate');
    Route::post('verify', [AuthController::class, 'verify']);

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show'])->where('id', '[0-9]+');
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{id}', [UserController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('/{id}', [UserController::class, 'destroy'])->where('id', '[0-9]+');
    });

    Route::prefix('item')->group(function () {
        Route::get('/', [ItemController::class, 'index']);
        Route::get('/{id}', [ItemController::class, 'show'])->where('id', '[0-9]+');
        Route::post('/', [ItemController::class, 'store']);
        Route::put('/{id}', [ItemController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('/{id}', [ItemController::class, 'destroy'])->where('id', '[0-9]+');
    });

    Route::prefix('catalogo')->group(function () {
        Route::get('/', [CatalogoController::class, 'index']);
        Route::get('/{id}', [CatalogoController::class, 'show'])->where('id', '[0-9]+');
        Route::post('/', [CatalogoController::class, 'store']);
        Route::put('/{id}', [CatalogoController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('/{id}', [CatalogoController::class, 'destroy'])->where('id', '[0-9]+');
    });
});