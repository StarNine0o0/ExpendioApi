<?php
// app/Models/Usuario.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;
    protected $fillable = ['nombre_usuario', 'contrasena', 'id_rol', 'estado', 'email'];
    protected $hidden = ['contrasena']; // Oculta la contraseña
}