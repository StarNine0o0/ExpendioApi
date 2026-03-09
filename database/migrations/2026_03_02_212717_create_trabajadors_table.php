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
        Schema::create('trabajadors', function (Blueprint $table) {
            $table->id('id_trabajador');
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->date('fecha_nacimiento');
            $table->string('telefono');
            $table->string('direccion');
            $table->date('fecha_contratacion');
            $table->decimal('salario', 10, 2);
            $table->string('puesto');


            $table->unsignedBigInteger('id_sucursal');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_rol');

            $table->foreign('id_sucursal')->references('id_sucursal')->on('sucursals')->onUpdate('cascade');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onUpdate('cascade');
            $table->foreign('id_rol')->references('id_rol')->on('roles')->onUpdate('cascade');

            $table->enum('estado', ['activo', 'bloqueado'])->default('bloqueado');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trabajadors');
    }
};
