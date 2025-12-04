<?php

namespace App\Http\Controllers;

use App\Models\Producto;

class ProductoController extends Controller
{
    public function index()
    {
        return response()->json(
            Producto::where('estado', 'activo')->get(),
            200
        );
    }
}
