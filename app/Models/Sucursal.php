<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sucursal extends Model
{
    use HasFactory;

    protected $table = 'sucursales';
    protected $primaryKey = 'id_sucursal';
    public $timestamps = false;

    protected $fillable = [
        'id_sucursal',
        'nombre',
        'codigo_sucursal',
        'direccion',
        'colonia',
        'ciudad',
        'codigo_postal',
        'telefono',
        'correo',      
        'encargado'
    ];

    public function trabajadores()
    {
        return $this->hasMany(Trabajador::class, 'id_sucursal', 'id_sucursal'); 
    }


    public function productoAlmacen()
    {
        return $this->hasMany(ProductoAlmacen::class, 'id_sucursal', 'id_sucursal');
    }


        public function inventarios()
        {
            return $this->hasMany(ProductoAlmacen::class, 'id_sucursal', 'id_sucursal');
        }


}
