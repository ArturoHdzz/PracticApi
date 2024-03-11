<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\ModeloController;

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
});

Route::group([
    'middleware' => ['api', 'auth:api'],
    'prefix' => 'auth'
], function ($router) {
    Route::get('user', [UserController::class, 'index']);
    Route::get('user/{id}', [UserController::class, 'show'])->where('id', '[0-9]+');
    Route::post('user', [UserController::class, 'store']);
    Route::put('user/{id}', [UserController::class, 'update'])->where('id', '[0-9]+');
    Route::delete('user/{id}', [UserController::class, 'destroy'])->where('id', '[0-9]+');

    Route::get('item', [ItemController::class, 'index']);
    Route::get('item/{id}', [ItemController::class, 'show'])->where('id', '[0-9]+');
    Route::post('item', [ItemController::class, 'store']);
    Route::put('item/{id}', [ItemController::class, 'update'])->where('id', '[0-9]+');
    Route::delete('item/{id}', [ItemController::class, 'destroy'])->where('id', '[0-9]+');

    Route::get('catalogo', [CatalogoController::class, 'index']);
    Route::get('catalogo/{id}', [CatalogoController::class, 'show'])->where('id', '[0-9]+');
    Route::post('catalogo', [CatalogoController::class, 'store']);
    Route::put('catalogo/{id}', [CatalogoController::class, 'update'])->where('id', '[0-9]+');
    Route::delete('catalogo/{id}', [CatalogoController::class, 'destroy'])->where('id', '[0-9]+');

    Route::get('modelo', [ModeloController::class, 'index']);
    Route::get('modelo/{id}', [ModeloController::class, 'show'])->where('id', '[0-9]+');
    Route::post('modelo', [ModeloController::class, 'store']);
    Route::put('modelo/{id}', [ModeloController::class, 'update'])->where('id', '[0-9]+');
    Route::delete('modelo/{id}', [ModeloController::class, 'destroy'])->where('id', '[0-9]+');
    
});

