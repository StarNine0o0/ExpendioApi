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
    /**
     * GET /api/productos
     * Muestra la lista de productos con su marca, categoría y stock.
     */
    public function index()
    {
        // Cargamos las relaciones para que el JSON venga completo
        $productos = Producto::with(['marca', 'categoria', 'productoAlmacen.sucursal'])
                             ->orderBy('nombre', 'asc')
                             ->paginate(15); // Paginación de 15 en 15

        return response()->json([
            'status' => 'success',
            'data' => $productos
        ]);
    }

    /**
     * POST /api/productos
     * Crea un producto nuevo y su stock inicial.
     */
    public function store(Request $request)
    {
        // 1. Validar los datos que entran
        $validated = $request->validate([
            // Datos de la tabla PRODUCTO
            'nombre'           => 'required|string|max:50|unique:producto,nombre',
            'codigo_barra'     => 'nullable|string|max:50',
            'costo_inventario' => 'required|numeric|min:0',
            'precio_unitario'  => 'required|numeric|min:0',
            'presentacion'     => ['required', Rule::in(['355ml', '473ml', '1l'])],
            'tipo_envase'      => ['required', Rule::in(['lata', 'botella', 'barril'])],
            'id_categoria'     => 'required|integer|exists:categorias,id_categoria',
            'id_marca'         => 'required|integer|exists:marcas,id_marca',
            'descripcion'      => 'nullable|string|max:200',
            
            // Datos extra para la tabla PRODUCTO_ALMACEN (Stock Inicial)
            'stock_inicial'    => 'required|integer|min:0',
            'id_sucursal'      => 'required|integer|exists:sucursales,id_sucursal',
            'ubicacion'        => 'nullable|string|max:50',
        ]);

        // 2. Iniciar Transacción (Todo o Nada)
        DB::beginTransaction();

        try {
            // A. Crear el Producto
            $producto = Producto::create([
                'nombre'           => $validated['nombre'],
                'codigo_barra'     => $validated['codigo_barra'],
                'costo_inventario' => $validated['costo_inventario'],
                'precio_unitario'  => $validated['precio_unitario'],
                'presentacion'     => $validated['presentacion'],
                'tipo_envase'      => $validated['tipo_envase'],
                'id_categoria'     => $validated['id_categoria'],
                'id_marca'         => $validated['id_marca'],
                'descripcion'      => $validated['descripcion'] ?? null,
                'fecha_ingreso'    => now(),
                'stock'            => $validated['stock_inicial'], // Stock global
                'estado'           => 'activo',
            ]);

            // B. Asignar el Stock en la Sucursal (Tabla PRODUCTO_ALMACEN)
            ProductoAlmacen::create([
                'id_producto'  => $producto->id_producto, // Usamos el ID recién creado
                'id_sucursal'  => $validated['id_sucursal'],
                'stock_actual' => $validated['stock_inicial'],
                'ubicacion'    => $validated['ubicacion'] ?? 'Bodega',
                'estado'       => 'disponible',
            ]);

            // Si todo salió bien, guardamos los cambios
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Producto creado correctamente',
                'data' => $producto->load('productoAlmacen')
            ], 201);

        } catch (\Exception $e) {
            // Si algo falla, deshacemos todo
            DB::rollBack();
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error al guardar el producto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/productos/{id}
     * Muestra un producto específico.
     */
    public function show($id)
    {
        $producto = Producto::with(['marca', 'categoria', 'productoAlmacen'])->find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $producto]);
    }

    /**
     * PUT /api/productos/{id}
     * Actualiza un producto.
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $validated = $request->validate([
            'nombre'           => ['sometimes', 'string', 'max:50', Rule::unique('producto', 'nombre')->ignore($id, 'id_producto')],
            'precio_unitario'  => 'sometimes|numeric|min:0',
            // Agrega aquí los demás campos que quieras permitir editar...
        ]);

        $producto->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Producto actualizado',
            'data' => $producto
        ]);
    }

    /**
     * DELETE /api/productos/{id}
     * Elimina un producto.
     */
    public function destroy($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }


        $producto->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Producto eliminado'
        ]);
    }
}