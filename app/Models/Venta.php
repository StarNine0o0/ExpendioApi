<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = 'id_venta';
    public $timestamps = false;

    protected $fillable = [
        'id_trabajador', 'id_caja', 'id_metodo_pago', 'fecha', 
        'descuento_porcentaje', 'total', 'monto_recibido', 'estado'
    ];

    protected $casts = [
        'fecha' => 'datetime',
        'descuento_porcentaje' => 'decimal:2',
        'total' => 'decimal:2',
        'monto_recibido' => 'decimal:2'
    ];

    // relaciones

    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class, 'id_trabajador', 'id_trabajador');
    }

    public function caja()
    { //falta tabla-models de cajas
        return $this->belongsTo(Caja::class, 'id_caja', 'id_caja');
    }

    public function metodoPago()
    { //falta tabla de tabla-models de pago
        return $this->belongsTo(MetodoPago::class, 'id_metodo_pago', 'id_metodo_pago');
    }

    public function detallesVenta()
    {
        return $this->hasMany(DetalleVenta::class, 'id_venta', 'id_venta');
    }

}
