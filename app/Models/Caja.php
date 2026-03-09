<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table = 'cajas';
    protected $primaryKey = 'id_caja';
    public $timestamps = false;

    protected $fillable = [
        'id_trabajador', 'fecha_apertura', 'fecha_cierre', 
        'monto_inicial', 'monto_final', 'estado'
    ];

    protected $casts = [
        'fecha_apertura' => 'datetime',
        'fecha_cierre' => 'datetime',
        'monto_inicial' => 'decimal:2',
        'monto_final' => 'decimal:2'
    ];

    // relaciones

    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class, 'id_trabajador', 'id_trabajador');
    }
}
