<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Importante para los tokens

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Apuntamos a tu tabla personalizada
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false; // Tu tabla usuarios no tiene created_at/updated_at

    protected $fillable = [
        'nombre_usuario',
        'email',
        'contrasena',
        'id_rol',
        'estado',
    ];

    protected $hidden = [
        'contrasena',
    ];

    // Le decimos a Laravel que la contraseña está en la columna 'contrasena'
    public function getAuthPassword()
    {
        return $this->contrasena;
    }
}