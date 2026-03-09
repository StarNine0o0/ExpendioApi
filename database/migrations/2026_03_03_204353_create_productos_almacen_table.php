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
        Schema::create('productos_almacen', function (Blueprint $table) {
            $table->id('id_producto_sucursal');
            $table->unsignedBigInteger('id_producto');
            $table->unsignedBigInteger('id_sucursal');
            $table->integer('stock_actual');
            $table->string('ubicacion');
            $table->enum('estado', ['agotado', 'disponible', 'dañado'])->default('disponible');

            $table->foreign('id_producto')->references('id_producto')->on('productos')->onDelete('cascade');
            $table->foreign('id_sucursal')->references('id_sucursal')->on('sucursales')->onDelete('cascade');



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos_almacen');
    }
};
