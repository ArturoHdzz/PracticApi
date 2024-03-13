<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\DetalleCompraController;
use App\Http\Controllers\ReseñaController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\DetallePedidoController;
use App\Http\Controllers\PedidoController;

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
    Route::get('verifytoken', [AuthController::class, 'verifytoken']);
});

Route::group([
    'middleware' => ['api', 'auth:api'],
    'prefix' => 'auth'
], function ($router) {
    //SOLO ADMIN
    Route::group(['middleware' => 'only.admin'], function ($router) {
        Route::get('user', [UserController::class, 'index']);
        Route::get('user/roles', [UserController::class, 'roles']);
        Route::get('user/{id}', [UserController::class, 'show'])->where('id', '[0-9]+');
        Route::post('user', [UserController::class, 'store']);
        Route::put('user/{id}', [UserController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('user/{id}', [UserController::class, 'destroy'])->where('id', '[0-9]+');

        Route::post('item', [ItemController::class, 'store']);
        Route::put('item/{id}', [ItemController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('item/{id}', [ItemController::class, 'destroy'])->where('id', '[0-9]+');

        Route::delete('catalogo/{id}', [CatalogoController::class, 'destroy'])->where('id', '[0-9]+');

        Route::post('modelo', [ModeloController::class, 'store']);
        Route::put('modelo/{id}', [ModeloController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('modelo/{id}', [ModeloController::class, 'destroy'])->where('id', '[0-9]+');

        Route::post('metodopago', [MetodoPagoController::class, 'store']);
        Route::put('metodopago/{id}', [MetodoPagoController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('metodopago/{id}', [MetodoPagoController::class, 'destroy'])->where('id', '[0-9]+');
       
        Route::get('compra/user', [CompraController::class, 'showuser']);
        Route::get('compra/metodopago', [CompraController::class, 'showmetodopago']);
        Route::post('compra', [CompraController::class, 'store']);
        Route::put('compra/{id}', [CompraController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('compra/{id}', [CompraController::class, 'destroy'])->where('id', '[0-9]+');

        Route::post('detallecompra', [DetalleCompraController::class, 'store']);
        Route::put('detallecompra/{id}', [DetalleCompraController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('detallecompra/{id}', [DetalleCompraController::class, 'destroy'])->where('id', '[0-9]+');

        Route::post('reseña', [ReseñaController::class, 'store']);
        Route::put('reseña/{id}', [ReseñaController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('reseña/{id}', [ReseñaController::class, 'destroy'])->where('id', '[0-9]+');

        Route::post('favorito', [FavoritoController::class, 'store']);
        Route::put('favorito/{id}', [FavoritoController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('favorito/{id}', [FavoritoController::class, 'destroy'])->where('id', '[0-9]+');

        Route::post('detallepedido', [DetallePedidoController::class, 'store']);
        Route::put('detallepedido/{id}', [DetallePedidoController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('detallepedido/{id}', [DetallePedidoController::class, 'destroy'])->where('id', '[0-9]+');

        Route::post('pedido', [PedidoController::class, 'store']);
        Route::put('pedido/{id}', [PedidoController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('pedido/{id}', [PedidoController::class, 'destroy'])->where('id', '[0-9]+');
    });

    //ADMIN Y INVITADO
    Route::group(['middleware' => 'admin.guest'], function ($router) {
        Route::get('item', [ItemController::class, 'index']);
        Route::get('item/{id}', [ItemController::class, 'show'])->where('id', '[0-9]+');

        Route::get('modelo', [ModeloController::class, 'index']);
        Route::get('modelo/{id}', [ModeloController::class, 'show'])->where('id', '[0-9]+');

        Route::get('metodopago', [MetodoPagoController::class, 'index']);
        Route::get('metodopago/{id}', [MetodoPagoController::class, 'show'])->where('id', '[0-9]+');

        Route::get('compra', [CompraController::class, 'index']);
        Route::get('compra/{id}', [CompraController::class, 'show'])->where('id', '[0-9]+');

        Route::get('detallecompra', [DetalleCompraController::class, 'index']);
        Route::get('detallecompra/{id}', [DetalleCompraController::class, 'show'])->where('id', '[0-9]+');

        Route::get('reseña', [ReseñaController::class, 'index']);
        Route::get('reseña/{id}', [ReseñaController::class, 'show'])->where('id', '[0-9]+');

        Route::get('favorito', [FavoritoController::class, 'index']);
        Route::get('favorito/{id}', [FavoritoController::class, 'show'])->where('id', '[0-9]+');

        Route::get('detallepedido', [DetallePedidoController::class, 'index']);
        Route::get('detallepedido/{id}', [DetallePedidoController::class, 'show'])->where('id', '[0-9]+');

        Route::get('pedido', [PedidoController::class, 'index']);
        Route::get('pedido/{id}', [PedidoController::class, 'show'])->where('id', '[0-9]+');
    });

    //ADMIN, USUARIO Y INVITADO
    Route::group(['middleware' => 'admin.user.guest'], function ($router) {
        Route::get('catalogo', [CatalogoController::class, 'index']);
        Route::get('catalogo/{id}', [CatalogoController::class, 'show'])->where('id', '[0-9]+');
    });

    //ADMIN, Y USUARIO
    Route::group(['middleware' => 'admin.user'], function ($router) {
        Route::post('catalogo', [CatalogoController::class, 'store']);
        Route::put('catalogo/{id}', [CatalogoController::class, 'update'])->where('id', '[0-9]+');
    });
});
