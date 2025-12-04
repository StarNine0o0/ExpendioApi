<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class ProductoAlmacen extends Model
{
    use hasFactory;

    protected $table = 'producto_almacen';
    protected $primaryKey = 'id_producto_sucursal';
    public $timestamps = false;

    protected $fillable = [
        'id_producto_sucursal',
        'id_producto',
        'id_sucursal',
        'stock_actual',
        'ubicacion',
        'estado'
    ];

    // Relación con el modelo Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    // Relación con el modelo Sucursal
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursal');
    }
}
