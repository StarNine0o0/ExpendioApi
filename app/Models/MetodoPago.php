<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    protected $table = 'metodo_pago';
    protected $primaryKey = 'id_metodo_pago';
    public $timestamps = false;

    protected $fillable = [
        'nombre_metodo_pago', 'descripcion', 'estado'
    ];

    // relaciones

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'id_metodo_pago', 'id_metodo_pago');
    }
}
