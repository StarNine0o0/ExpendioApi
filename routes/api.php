<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompraController;
use App\Http\Controllers\Api\ProveedorController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\AlmacenistaController;
use Illuminate\Support\Facades\Route;

// LOGIN
Route::post('login', [AuthController::class, 'login']);

// PRODUCTOS (solo activos)
Route::get('productos', [ProductoController::class, 'index']);

// COMPRAS
Route::apiResource('compras', CompraController::class);

// PROVEEDORES
Route::get('/proveedores', [ProveedorController::class, 'index']);

// ALMACENISTAS - Gestión de empleados almacenistas
Route::prefix('almacenistas')->group(function () {
    // Obtener todos los almacenistas
    Route::get('/', [AlmacenistaController::class, 'index']);
    
    // Bloquear almacenista
    Route::post('/{id}/bloquear', [AlmacenistaController::class, 'bloquear']);
    
    // Desbloquear almacenista
    Route::post('/{id}/desbloquear', [AlmacenistaController::class, 'desbloquear']);
});