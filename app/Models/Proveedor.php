<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'PROVEEDORES';   // O 'proveedores' según tu DB
    protected $primaryKey = 'id_proveedores';
    public $timestamps = false;

    protected $fillable = [
        'estado',
        'nombre',
        'direccion',
        'email',
        'telefono'
    ];

    public function compras()
    {
        return $this->hasMany(Compra::class, 'id_proveedor', 'id_proveedores');
    }
}
