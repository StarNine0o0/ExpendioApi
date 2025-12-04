<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    protected $table = 'MOVIMIENTO_INVENTARIO'; 

    protected $primaryKey = 'id_movimiento'; 
    
    public $timestamps = false;
    
    protected $fillable = [
        'id_producto',
        'id_sucursal',
        'id_usuario',
        'tipo_movimiento',
        'referencia_tipo',
        'cantidad',
        'motivo',
        'fecha'
    ];
}