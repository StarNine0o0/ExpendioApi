<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;       // Tu modelo principal
use App\Models\ProductoAlmacen; // Para el stock
use Illuminate\Support\Facades\DB; // Para transacciones (seguridad de datos)
use Illuminate\Validation\Rule;

class InventarioController extends Controller
{

   
    public function index(Request $request)
    {
        // Cargamos las relaciones para que el JSON venga completo
        $productos = Producto::with(['marca', 'categoria', 'productoAlmacen.sucursal'])
                             ->orderBy('nombre', 'asc');
                             

        //filtro de busqueda por nombre o codigo de barra
        if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $productos->where(function ($query) use ($search) {
            $query->where('nombre', 'like', "%{$search}%")
                  ->orWhere('codigo_barra', 'like', "%{$search}%");
        });
    }

    //filtro por categoria
    if ($request->has('categoria_id') && $request->categoria_id != '') {
        $productos->where('id_categoria', $request->categoria_id);
    }
    //filtro por estado
    if ($request->has('stock_status') && $request->stock_status != '') {
        $status = $request->stock_status;
        
        $productos->whereHas('productoAlmacen', function ($query) use ($status) {
            if ($status === 'agotado') {
                $query->where('stock_actual', '<=', DB::raw('productos.stock_minimo'));
            } elseif ($status === 'disponible') {
                $query->where('stock_actual', '>', DB::raw('productos.stock_minimo'));
            }
            // NOTA: Esta lógica requiere que la tabla PRODUCTO_ALMACEN tenga el stock mínimo.
          
        });
    }

    return response()->json([
        'status' => 'success',
        'data' => $productos->paginate(20)
    ]);
}

public function store(Request $request){ // Crear nuevo producto con stock inicial en una sucursal

    $validatedData = $request->validate([
        'nombre'        =>  'required|string|max:255',
        'codigo_barra'  => 'nullable|string|max:100',
        'costo_inventario' => 'required|numeric|min:0',
        'precio_unitario' => 'required|numeric|min:0|gte:costo_inventario',
        'presentacion' => ['required', \Illuminate\Validation\Rule::in(['355ml', '473ml', '1l'])],
        'tipo_envase'  => ['required', \Illuminate\Validation\Rule::in(['lata', 'botella', 'barril'])],
        'id_categoria' => 'required|integer|exists:categorias,id_categoria',
        'id_marca' => 'required|integer|exists:marcas,id_marca',
        'descripcion' => 'nullable|string|max:200',


        'stock_minimo' => 'nullable|integer|min:0',
        'stock_maximo' => 'nullable|integer|min:0',

        //datosd el stok inicial
        'stock_inicial' => 'required|integer|min:0',
        'id_sucursal' => 'required|integer|exists:sucursales,id_sucursal',

       
    ]);

    DB::beginTransaction();

    try {
        // Crear el registro del producto
        $producto = \App\Models\Producto::create([
            'nombre' => $validatedData['nombre'],
            'codigo_barra' => $validatedData['codigo_barra'] ?? null,
            'costo_inventario' => $validatedData['costo_inventario'],
            'precio_unitario' => $validatedData['precio_unitario'],
            'presentacion' => $validatedData['presentacion'],
            'tipo_envase' => $validatedData['tipo_envase'],
            'id_categoria' => $validatedData['id_categoria'],
            'id_marca' => $validatedData['id_marca'],
            'descripcion' => $validatedData['descripcion'] ?? null,

            'stock_actual' => $validatedData['stock_inicial'],
            "stock_minimo" => data_get($validatedData, 'stock_minimo', 10), // Valor por defecto si no se proporciona
            'stock_maximo' => data_get($validatedData, 'stock_maximo', 100), // Valor por defecto si no se proporciona
            'fecha_ingreso' => now(),
            'estado' => 'activo',
        ]);

        // Crear el registro en producto_almacen para el stock inicial
        \App\Models\ProductoAlmacen::create([
            'id_producto' => $producto->id_producto,
            'id_sucursal' => $validatedData['id_sucursal'],
            'stock_actual' => $validatedData['stock_inicial'],
            'estado' => 'disponible',
        ]);


        DB::commit();// Confirmar la transacción

        return response()->json([
            'status' => 'success',
            'message' => 'Producto registrado correctamente',
            'data' => $producto->load(['marca', 'categoria', 'productoAlmacen'])
        ], 201);

    } catch (\Exception $e) {
        DB::rollBack();// Revertir la transacción en caso de error
        return response()->json([
            'status' => 'error',
            'message' => 'Error al crear el producto',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function update(Request $request, $id_producto)
{  // Lógica para actualizar un producto existente
    $producto = \App\Models\Producto::find($id_producto);

    if (!$producto) {// Verificamos si el producto existe si no retornamos error
        return response()->json([
            'status' => 'error',
            'message' => 'Producto no encontrado'
        ], 404);
    }
    
    $costo_base = $request->input('costo_inventario', $producto->costo_inventario);// Costo actual o el nuevo si se proporciona
    $validatedData = $request->validate([
        'nombre'        =>  ['sometimes', 'string', 'max:50', \Illuminate\Validation\Rule::unique('producto', 'nombre')->ignore($id_producto, 'id_producto')],
        'codigo_barra'  => 'nullable|string|max:100',
        'costo_inventario' => 'sometimes|numeric|min:0',
        'precio_unitario' => ['sometimes', 'numeric', 'min:0', 'gte:'.$costo_base], //
        'descripcion' => 'nullable|string|max:200',
        'estado' => ['sometimes', \Illuminate\Validation\Rule::in(['activo', 'desactivado'])],

        'id_categoria' => 'sometimes|integer|exists:categorias,id_categoria',
        'id_marca' => 'sometimes|integer|exists:marcas,id_marca',

    ]);

    $producto->update($validatedData);

    return response()->json([
        'status' => 'success',
        'message' => 'Producto actualizado correctamente',
        'data' => $producto->load(['marca', 'categoria'])
    ],200);
}
    public function destroy($id_producto)
    {
        $producto = \App\Models\Producto::find($id_producto);

        if (!$producto) {
            return response()->json([
                'status' => 'error',
                'message' => 'Producto no encontrado'
            ], 404);
        }

        // Aquí podrías implementar una eliminación lógica si prefieres no borrar registros físicamente
        $producto->update(['estado' => 'desactivado']);

        return response()->json([
            'status' => 'success',
            'message' => 'Producto bloqueado correctamente'
        ]);
    }





}

