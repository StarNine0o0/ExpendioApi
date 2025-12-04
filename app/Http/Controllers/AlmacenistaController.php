<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class AlmacenistaController extends Controller
{
    /**
     * Obtener todos los almacenistas
     * GET /api/almacenistas
     */
    public function index()
    {
        try {
            // Obtener todos los usuarios cuyo rol sea "Almacenista" (case-insensitive)
            $almacenistas = Usuario::with(['trabajador', 'rol'])
                ->whereHas('rol', function($query) {
                    $query->whereRaw('LOWER(nombre_rol) = ?', ['almacenista']);
                })
                ->get()
                ->map(function($usuario) {
                    $trabajador = $usuario->trabajador;

                    return [
                        'id' => $usuario->id_usuario,
                        'nombre' => $trabajador 
                            ? $trabajador->nombre_completo 
                            : $usuario->nombre_usuario,
                        'esta_bloqueado' => $usuario->estado === 'bloqueado'
                    ];
                });

            return response()->json($almacenistas, 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener almacenistas',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bloquear un almacenista
     * POST /api/almacenistas/{id}/bloquear
     */
    public function bloquear($id)
    {
        try {
            $usuario = Usuario::with('rol')->findOrFail($id);

            if (strtolower($usuario->rol->nombre_rol) !== 'almacenista') {
                return response()->json([
                    'error' => 'El usuario no es un almacenista'
                ], 400);
            }

            $usuario->estado = 'bloqueado';
            $usuario->save();

            return response()->json([
                'message' => 'Almacenista bloqueado exitosamente',
                'usuario' => [
                    'id' => $usuario->id_usuario,
                    'estado' => $usuario->estado
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al bloquear almacenista',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Desbloquear un almacenista
     * POST /api/almacenistas/{id}/desbloquear
     */
    public function desbloquear($id)
    {
        try {
            $usuario = Usuario::with('rol')->findOrFail($id);

            if (strtolower($usuario->rol->nombre_rol) !== 'almacenista') {
                return response()->json([
                    'error' => 'El usuario no es un almacenista'
                ], 400);
            }

            $usuario->estado = 'activo';
            $usuario->save();

            return response()->json([
                'message' => 'Almacenista desbloqueado exitosamente',
                'usuario' => [
                    'id' => $usuario->id_usuario,
                    'estado' => $usuario->estado
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al desbloquear almacenista',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener un almacenista específico
     * GET /api/almacenistas/{id}
     */
    public function show($id)
    {
        try {
            $usuario = Usuario::with(['trabajador', 'rol'])->findOrFail($id);

            if (strtolower($usuario->rol->nombre_rol) !== 'almacenista') {
                return response()->json([
                    'error' => 'El usuario no es un almacenista'
                ], 400);
            }

            $trabajador = $usuario->trabajador;

            return response()->json([
                'id' => $usuario->id_usuario,
                'nombre' => $trabajador->nombre_completo,
                'email' => $usuario->email,
                'telefono' => $trabajador->telefono,
                'puesto' => $trabajador->puesto,
                'estado' => $usuario->estado,
                'esta_bloqueado' => $usuario->estado === 'bloqueado'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Almacenista no encontrado',
                'message' => $e->getMessage()
            ], 404);
        }
    }
}
