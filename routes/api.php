<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompraController;
use App\Http\Controllers\Api\ProveedorController;
use App\Http\Controllers\Api\InventarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\AlmacenistaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas de API
|--------------------------------------------------------------------------
| Aquí se definen todas las rutas del API para tu aplicación.
| Todas estas rutas tienen el prefijo /api/ automáticamente.
*/

// =========================================================================
// 1. AUTENTICACIÓN
// =========================================================================
Route::post('login', [AuthController::class, 'login']);

// =========================================================================
// 2. GESTIÓN DE ALMACENISTAS
// =========================================================================
Route::prefix('almacenistas')->group(function () {
    Route::get('/', [AlmacenistaController::class, 'index']);
    Route::post('/{id}/bloquear', [AlmacenistaController::class, 'bloquear']);
    Route::post('/{id}/desbloquear', [AlmacenistaController::class, 'desbloquear']);
});

// =========================================================================
// 3. INVENTARIO DE PRODUCTOS (CRUD Completo)
// =========================================================================
// Usa InventarioController para el CRUD completo
Route::apiResource('productos', InventarioController::class);

// Si necesitas la ruta simple de ProductoController (solo lectura)
Route::get('productos-activos', [ProductoController::class, 'index']);
// descomenta esta línea:

// =========================================================================
// 4. COMPRAS
// =========================================================================
Route::apiResource('compras', CompraController::class);

// =========================================================================
// 5. PROVEEDORES
// =========================================================================
Route::get('proveedores', [ProveedorController::class, 'index']);