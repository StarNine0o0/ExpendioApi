<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'producto';
    protected $primaryKey = 'id_producto';
    public $timestamps = false;

    protected $fillable = [
        'nombre', 'stock', 'fecha_ingreso', 'codigo_barra', 
        'costo_inventario', 'imagen_url', 'descripcion', 
        'precio_unitario', 'estado', 'stock_minimo', 
        'stock_actual', 'stock_maximo', 'presentacion', 
        'tipo_envase', 'id_categoria', 'id_marca'
        
    ];

    // relaciones

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'id_marca', 'id_marca');
    }

    public function productoAlmacen()
    {
        return $this->hasMany(ProductoAlmacen::class, 'id_producto', 'id_producto');
    }
}