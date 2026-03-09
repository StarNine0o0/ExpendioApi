<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sucursales', function (Blueprint $table) {
            $table->id('id_sucursal');
            $table->string('nombre');
            $table->string('direccion');
            $table->string('colonia')->nullable();
            $table->string('ciudad');
            $table->string('codigo_postal');
            $table->string('telefono');
            $table->string('encargado');
            $table->enum('estado', ['activo', 'bloqueado'])->default('activo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sucursales');
    }
};
