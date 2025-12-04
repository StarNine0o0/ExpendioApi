<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    // Listar proveedores activos
    public function index()
    {
        return response()->json(
            Proveedor::where('estado', 'activo')->get()
        );
    }

    // Crear proveedor
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'direccion' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
            'telefono' => 'nullable|string|max:20'
        ]);

        // Valor por defecto
        $validated['estado'] = 'activo';

        $proveedor = Proveedor::create($validated);

        return response()->json([
            'message' => 'Proveedor creado exitosamente',
            'data' => $proveedor
        ], 201);
    }

    // Obtener un proveedor
    public function show($id)
    {
        $proveedor = Proveedor::where('estado', 'activo')
                              ->findOrFail($id);

        return response()->json($proveedor);
    }

    // Actualizar proveedor
    public function update(Request $request, $id)
    {
        $proveedor = Proveedor::where('estado', 'activo')
                              ->findOrFail($id);

        $proveedor->update($request->only([
            'nombre', 'direccion', 'email', 'telefono'
        ]));

        return response()->json([
            'message' => 'Proveedor actualizado exitosamente',
            'data' => $proveedor
        ]);
    }

    // Desactivar proveedor (soft-delete manual)
    public function destroy($id)
    {
        $proveedor = Proveedor::findOrFail($id);

        $proveedor->update(['estado' => 'inactivo']);

        return response()->json([
            'message' => 'Proveedor desactivado exitosamente'
        ]);
    }
}
