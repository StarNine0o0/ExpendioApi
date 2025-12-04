<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\InventarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas de API
|--------------------------------------------------------------------------
*/

// =========================================================================
// 1. RUTA DE AUTENTICACIÓN (LOGIN SIMPLE)
// =========================================================================
// Endpoint: POST /api/login
// Llama al método 'login' del AuthController para la verificación de usuario.
Route::post('login', [AuthController::class, 'login']);


// =========================================================================
// 2. RUTAS DEL INVENTARIO (CRUD PÚBLICO TEMPORAL)
// =========================================================================
// Route::apiResource genera automáticamente 7 rutas para el CRUD de productos:
// GET    /api/productos       (Llamará a InventarioController@index)
// POST   /api/productos       (Llamará a InventarioController@store)
// GET    /api/productos/{id}  (Llamará a InventarioController@show)
// ... etc.
Route::apiResource('productos', InventarioController::class);
Route::get('sucursales-listado', [InventarioController::class, 'getSucursalesListado']);
Route::get('almacenistas-listado', [InventarioController::class, 'getAlmacenistasListado']);
Route::post('traspaso', [InventarioController::class, 'storeTraspaso']);