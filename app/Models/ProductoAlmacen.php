<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Nota: Si no usas la clase Sucursal aquí, puedes omitir el use, pero es bueno si la tienes.
// use App\Models\Sucursal; 

class ProductoAlmacen extends Model
{
    use HasFactory;
    
    // Configuración de tabla (usando mayúsculas, si así está en tu BD)
    protected $table = 'PRODUCTO_ALMACEN'; 

    // Clave primaria correcta de tu tabla
    protected $primaryKey = 'id_producto_sucursal'; 

    // Desactivar timestamps si solo usas las columnas de stock/ubicación
    public $timestamps = false;
    
    // *** ¡LA PROPIEDAD FILLABLE ES LA CLAVE PARA ELIMINAR EL ERROR DE ASIGNACIÓN MASIVA! ***
    protected $fillable = [
        'id_producto',
        'id_sucursal',
        'stock_actual',
        'ubicacion', 
        'estado'
    ];
    
    // Ejemplo de relación (puedes dejarlo si ya lo tenías)
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursal', 'id_sucursal');
    }
}