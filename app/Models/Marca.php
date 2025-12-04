<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    
    // Configuraciones necesarias para Eloquent
    protected $table = 'marcas'; 
    protected $primaryKey = 'id_marca'; 
    public $timestamps = false;

    // Aquí iría el método de relación 'productos()' si lo necesitaras, pero por ahora esto basta.
}