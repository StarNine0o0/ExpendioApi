<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Marca extends Model
{
    use HasFactory;

    protected $table = 'marcas';
    protected $primaryKey = 'id_marca';
    public $timestamps = false;


    protected $fillable = [
        'id_marca',
        'nombre',
        'estado'
    ];

    public function productos()//relacion con productos
    {
        return $this->hasMany(Producto::class, 'id_marca', 'id_marca');
    }



}
