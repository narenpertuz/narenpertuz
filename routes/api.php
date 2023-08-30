<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CuentaController;
use App\Http\Controllers\PedidoController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas para Cuentas
Route::get('/get-cuentas', [CuentaController::class, 'index']);
Route::post('/create-cuenta', [CuentaController::class, 'store']);
Route::get('/get-cuenta/{cuenta}', [CuentaController::class, 'show']);
Route::put('/update-cuenta/{cuenta}', [CuentaController::class, 'update']);
Route::delete('/delete-cuenta/{cuenta}', [CuentaController::class, 'destroy']);

// Rutas para Pedidos
Route::get('/get-pedidos', [PedidoController::class, 'index']);
Route::post('/create-pedido', [PedidoController::class, 'store']);
Route::get('/get-pedido/{pedido}', [PedidoController::class, 'show']);
Route::put('/update-pedido/{pedido}', [PedidoController::class, 'update']);
Route::delete('/delete-pedido/{pedido}', [PedidoController::class, 'destroy']);
