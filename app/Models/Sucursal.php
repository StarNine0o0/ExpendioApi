<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;

    protected $table = 'sucursales';
    protected $primaryKey = 'id_sucursal';
    public $timestamps = false;

    protected $fillable = [
        'id_sucursal',
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

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursal');
    }


}
