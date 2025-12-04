<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'PRODUCTO';  // ← MAYÚSCULAS según tu DB
    protected $primaryKey = 'id_producto';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'stock',
        'fecha_ingreso',
        'codigo_barra',
        'costo_inventario',
        'imagen_url',
        'descripcion',
        'precio_unitario',
        'estado',
        'stock_minimo',
        'stock_actual',
        'stock_maximo',
        'presentacion',
        'tipo_envase',
        'id_categoria',
        'id_marca'
    ];

    // Relaciones
    
    // Un producto pertenece a una categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    // Un producto pertenece a una marca
    public function marca()
    {
        return $this->belongsTo(Marca::class, 'id_marca', 'id_marca');
    }

    // Un producto puede estar en varios almacenes
    public function productoAlmacen()
    {
        return $this->hasMany(ProductoAlmacen::class, 'id_producto', 'id_producto');
    }
}