<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';
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

    protected $casts = [
        'contrasena' => 'hashed'
    ];



    public function rol()
    { //la FK siempre va en el modelo que usa belongsTo
        return $this->belongsTo(Role::class, 'id_rol', 'id_rol');
    }
}
