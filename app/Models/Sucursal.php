<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $table = 'sucursales';
    protected $primaryKey = 'id_sucursal';
    public $timestamps = false;
    protected $fillable = ['nombre', 'codigo_sucursal', 'direccion', 'ciudad', 'encargado'];
}