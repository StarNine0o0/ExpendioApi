<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'USUARIOS';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'nombre_usuario',
        'contrasena',
        'estado',
        'email',
        'id_rol'
    ];

    protected $hidden = [
        'contrasena'
    ];

    // Relación: Un usuario pertenece a un rol
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
    }

    // Relación: Un usuario tiene un trabajador
    public function trabajador()
    {
        return $this->hasOne(Trabajador::class, 'id_usuario', 'id_usuario');
    }
}