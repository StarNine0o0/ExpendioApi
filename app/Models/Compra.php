<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = "COMPRAS";
    protected $primaryKey = "id_compras";
    public $timestamps = false;

    protected $fillable = [
        'id_proveedor',
        'fecha_compra',
        'estado',
        'total_compra',
        'numero_compra_factura',
    ];

    public function detalles()
    {
        return $this->hasMany(DetalleCompra::class, 'id_compra', 'id_compras');
    }
}
