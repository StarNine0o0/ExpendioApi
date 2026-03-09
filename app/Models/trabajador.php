<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class trabajador extends Model
{
    protected $table = 'trabajadores';
    protected $primaryKey = 'id_trabajador';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'telefono',
        'direccion',
        'fecha_contratacion',
        'salario',
        'puesto',
        'id_usuario',
        'id_sucursal',
        'id_rol',
        'estado'

    ];    

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_contratacion' => 'date',
        'salario' => 'decimal:2'
    ];
       

        public function sucursal()
        {
            return $this->belongsTo(Sucursal::class, 'id_sucursal', 'id_sucursal');
        }
        
         public function usuario()
        {
            return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
        }

        public function rol()
        {
            return $this->belongsTo(Role::class, 'id_rol', 'id_rol');
        }

        public function cajas()
        { //un tabajador puede abrir varias cajas a lo largo del tiempo
            return $this->hasMany(Caja::class, 'id_trabajador', 'id_trabajador');
        }


}
