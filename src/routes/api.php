<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\InventarioMovimientoController;

Route::get('/ping', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'API funcionando correctamente'
    ]);
});

Route::controller(AuthController::class)->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/login', 'login');
        Route::post('/logout', 'logout');
    });
});

Route::middleware('auth.api')->group(function () {

    Route::controller(UsuarioController::class)->group(function () {
        Route::prefix('usuarios')->group(function () {
            Route::get('/', 'listarUsuarios');
            Route::get('/{id}', 'obtenerUsuario');
            Route::post('/', 'agregarUsuario');
            Route::patch('/{id}', 'editarUsuario');
            Route::delete('/{id}', 'eliminarUsuario');
        });
    });

    Route::controller(ProductoController::class)->group(function () {
        Route::prefix('productos')->group(function () {
            Route::get('/', 'listarProductos');
            Route::get('/{id}', 'obtenerProducto');
            Route::post('/', 'agregarProducto');
            Route::patch('/{id}', 'editarProducto');
            Route::delete('/{id}', 'eliminarProducto');
        });
    });

    Route::controller(ClienteController::class)->group(function () {
        Route::prefix('clientes')->group(function () {
            Route::get('/', 'listarClientes');
            Route::get('/{id}', 'obtenerCliente');
            Route::post('/', 'agregarCliente');
            Route::patch('/{id}', 'editarCliente');
            Route::delete('/{id}', 'eliminarCliente');
        });
    });

    Route::controller(InventarioMovimientoController::class)->group(function () {
        Route::prefix('inventario-movimientos')->group(function () {
            Route::get('/', 'listarMovimientos');
            Route::post('/', 'agregarMovimiento');
        });
    });
});
