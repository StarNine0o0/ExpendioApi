<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mermas extends Model
{
    protected $table = 'mermas';
    protected $primaryKey = 'id_merma';
    public $timestamps = false;

    protected $fillable = [
        'id_trabajador',
        'id_producto',
        'id_sucursal',
        'fecha',
        'cantidad',
        'motivo',
        'costo_merma'
    ];

    protected $casts = [
        'fecha' => 'datetime',
        'costo_merma' => 'decimal:2'
    ];


    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class, 'id_trabajador', 'id_trabajador');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursal', 'id_sucursal');
    }
}
