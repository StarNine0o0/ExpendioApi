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
        'nombre_producto', 'codigo_barras', 'precio_compra', 'precio_venta', 'fecha_ingreso', 
        'imagen_url', 'descripcion', 'estado', 'stock_minimo', 'stock_maximo', 'presentacion',
        'tipo_envase', 'id_categoria', 'id_marca'
        
    ];

    // para convertir los campos a tipos específicos
    protected $casts = [
        'fecha_ingreso' => 'date',
        'precio_compra' => 'decimal:2',
        'precio_venta' => 'decimal:2'
        
    ];

    // relaciones

    public function categoria() 
    {return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria'); }
    public function marca()
    { return $this->belongsTo(Marca::class, 'id_marca', 'id_marca'); }
    public function inventarios()
    { return $this->hasMany(ProductoAlmacen::class, 'id_producto', 'id_producto');}
}
