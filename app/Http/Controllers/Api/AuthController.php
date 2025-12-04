<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate(['nombre_usuario' => 'required', 'contrasena' => 'required']);
    $user = User::where('nombre_usuario', $credentials['nombre_usuario'])->first();

        if (!$user){
            return response()->json([
                'status' => 'error',
                'message' => 'Usuario no encontrado',
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Inicio de sesión exitoso',
            'user_id' => $user->id_usuario,
            'nombre'=>$user->nombre_usuario,
            'id_rol'=>$user->id_rol,
        ], 200);



    }
}
