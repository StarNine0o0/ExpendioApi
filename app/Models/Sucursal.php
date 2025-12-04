<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;

    protected $table = 'SUCURSALES';  // ← MAYÚSCULAS según tu DB
    protected $primaryKey = 'id_sucursal';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'codigo_sucursal',
        'direccion',
        'colonia',
        'ciudad',
        'codigo_postal',
        'telefono',
        'correo',
        'encargado'
    ];

    // Relación: Una sucursal tiene muchos trabajadores
    public function trabajadores()
    {
        return $this->hasMany(Trabajador::class, 'id_sucursal', 'id_sucursal');
    }
}