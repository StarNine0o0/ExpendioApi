<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Marca; // ¡NECESARIO!
use App\Models\Categoria; // ¡NECESARIO!
use App\Models\ProductoAlmacen; // ¡NECESARIO!

class Producto extends Model
{
    use HasFactory;

    // Configuración de la tabla
    protected $table = 'producto'; 
    protected $primaryKey = 'id_producto'; 
    public $timestamps = false; 

    // Campos que se pueden llenar
    protected $fillable = [
        'nombre', 'codigo_barra', 'costo_inventario', 'precio_unitario', 
        'presentacion', 'tipo_envase', 'id_categoria', 'id_marca', 
        'descripcion', 'fecha_ingreso', 'stock', 'estado'
    ];

    // --- RELACIONES ELOQUENT ---

    // 1. Relación con Marca: Un producto pertenece a una Marca
    public function marca()
    {
        return $this->belongsTo(Marca::class, 'id_marca', 'id_marca');
    }

    // 2. Relación con Categoría: Un producto pertenece a una Categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    // 3. Relación con ProductoAlmacen: Un producto puede estar en varios almacenes/sucursales
    public function productoAlmacen()
    {
        return $this->hasMany(ProductoAlmacen::class, 'id_producto', 'id_producto');
    }
}