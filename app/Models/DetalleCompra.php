<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- FALTABA ESTO

class DetalleCompra extends Model
{
    use HasFactory;

    protected $table = 'DETALLE_COMPRA';
    protected $primaryKey = 'id_detalle_compra';
    public $timestamps = false;

    protected $fillable = [
        'id_compra',
        'id_producto',
        'subtotal',
        'cantidad'
    ];

    // Relación con Compra
    public function compra()
    {
        return $this->belongsTo(Compra::class, 'id_compra', 'id_compras');
    }

    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }
}

