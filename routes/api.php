<?php
/*| Rutas de API*/
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\InventarioController;
use Illuminate\Support\Facades\Route;


// Endpoint: POST /api/login
Route::post('login', [AuthController::class, 'login']);


// Endpoint base: /api/productos
Route::apiResource('productos', InventarioController::class);


//ruta inventario
Route::get('inventario', [InventarioController::class, 'index']);

// Endpoint: GET /api/categorias
Route::get('catalogos/categorias', function () {
    return \App\Models\Categoria::all();
});
// Endpoint: GET /api/cajas (Según tu requerimiento)
Route::get('catalogos/cajas', function () {
    return \App\Models\CAJAS::all();
});