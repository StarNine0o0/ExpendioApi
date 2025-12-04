<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use App\Models\DetalleCompra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    /**
     * Mostrar todas las compras
     */
    public function index()
    {
        return response()->json(
            Compra::with('detalles')->get(),
            200
        );
    }

    /**
     * Registrar una compra con sus detalles
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_proveedor' => 'required|integer',
            'fecha_compra' => 'required|date',
            'numero_compra_factura' => 'required|string',
            'detalles' => 'required|array|min:1',
            'detalles.*.id_producto' => 'required|integer',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio_unitario' => 'required|numeric|min:0'
        ]);

        try {
            DB::beginTransaction();

            // CALCULAR TOTAL
            $total = 0;
            foreach ($request->detalles as $det) {
                $total += $det['cantidad'] * $det['precio_unitario'];
            }

            // INSERTAR COMPRA
            $compra = Compra::create([
                'id_proveedor' => $request->id_proveedor,
                'fecha_compra' => $request->fecha_compra,
                'numero_compra_factura' => $request->numero_compra_factura,
                'total_compra' => $total,
                'estado' => 'pendiente'
            ]);

            // INSERTAR DETALLES
            foreach ($request->detalles as $det) {
                DetalleCompra::create([
                    'id_compra' => $compra->id_compras,
                    'id_producto' => $det['id_producto'],
                    'cantidad' => $det['cantidad'],
                    'subtotal' => $det['cantidad'] * $det['precio_unitario']
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Compra registrada correctamente',
                'data' => $compra
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al guardar la compra',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Eliminar compra
     */
    public function destroy($id)
    {
        try {
            $compra = Compra::findOrFail($id);

            // Eliminar detalles
            DetalleCompra::where('id_compra', $id)->delete();

            // Eliminar compra
            $compra->delete();

            return response()->json([
                'message' => 'Compra eliminada correctamente'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la compra',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
