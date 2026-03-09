<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $productos = Producto::with([
            'categoria',
            'marca',
            'productoAlmacen.sucursal'
        ])
        ->where('estado', 'activo') // <--- IMPORTANTE para que NO mande inactivos
        ->get();

        return response()->json([
            'status' => true,
            'data' => $productos
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $producto = Producto::create([
            'nombre'         => $request->nombre,
            'codigo_barra'   => $request->codigo_barra,
            'costo_inventario' => $request->costo_inventario,
            'precio_unitario'  => $request->precio_unitario,
            'stock_actual'     => $request->stock_actual,
            'stock_minimo'     => $request->stock_minimo ?? 10,
            'id_categoria'     => $request->id_categoria,
            'id_marca'         => $request->id_marca,
            'presentacion'     => $request->presentacion,
            'tipo_envase'      => $request->tipo_envase,
            'estado'           => 'activo',
            'descripcion'      => $request->descripcion
        ]);

        return response()->json([
            'status' => true,
            'data' => $producto
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $producto = Producto::findOrFail($id);

        $producto->update([
            'nombre'         => $request->nombre,
            'codigo_barra'   => $request->codigo_barra,
            'costo_inventario' => $request->costo_inventario,
            'precio_unitario'  => $request->precio_unitario,
            'stock_actual' => $request->stock_actual ?? $producto->stock_actual,
            'stock_minimo'     => $request->stock_minimo ?? $producto->stock_minimo,
            'id_categoria'     => $request->id_categoria,
            'id_marca'         => $request->id_marca,
            'presentacion'     => $request->presentacion,
            'tipo_envase'      => $request->tipo_envase,
            'descripcion'      => $request->descripcion
        ]);

        return response()->json([
            'status' => true,
            'data' => $producto
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
          $producto = Producto::findOrFail($id);
        $producto->estado = 'inactivo';
        $producto->save();

        return response()->json([
            'status' => true,
            'message' => 'Producto marcado como inactivo'
        ]);
    }
}
