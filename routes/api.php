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
Route::get('categorias', function () {
    return \App\Models\Categoria::all();
});

// Endpoint: GET /api/marcas
Route::get('marcas', function () {
    return \App\Models\Marca::all();
});
// Endpoint: GET /api/sucursales
Route::get('sucursales', function () {
    return \App\Models\Sucursal::all();
});
