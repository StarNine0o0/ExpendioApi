<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    
    // Configuraciones necesarias para Eloquent
    protected $table = 'categorias'; 
    protected $primaryKey = 'id_categoria'; 
    public $timestamps = false;
}