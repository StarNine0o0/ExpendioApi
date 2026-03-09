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
        Schema::create('productos', function (Blueprint $table) {
            $table->id('id_producto');
            $table->string('nombre_producto', 100);
            $table->string('codigo_barras')->nullable()->unique();
            $table->decimal('precio_compra', 10, 2);
            $table->decimal('precio_venta', 10, 2);
            $table->date('fecha_ingreso');
            $table->string('imagen_url')->nullable();
            $table->string('descripcion',255)->nullable();
            $table->enum('estado', ['activo', 'desactivado'])->default('activo');
            $table->integer('stock_minimo');
            $table->integer('stock_maximo');
            $table->string('presentacion')->nullable();
            $table->enum('tipo_envase', ['lata', 'botella', 'barril']);
            $table->unsignedBigInteger('id_categoria');
            $table->unsignedBigInteger('id_marca');
            $table->foreign('id_categoria')->references('id_categoria')->on('categorias')->onUpdate('cascade');
            $table->foreign('id_marca')->references('id_marca')->on('marcas')->onUpdate('cascade');
            $table->index('nombre_producto');
             //$table->index('nombre_marca');
             $table->index('codigo_barras');

        });
    }
    //corregir el modelo de producto y el de producto_almacen para que tenga el stock actual porr sucusal
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
