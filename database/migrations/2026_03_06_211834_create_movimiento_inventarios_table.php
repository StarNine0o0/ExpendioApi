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
        Schema::create('movimiento_inventarios', function (Blueprint $table) {
            $table->id('id_movimiento');
            $table->unsignedBigInteger('id_producto');
            $table->unsignedBigInteger('id_sucursal');
            $table->unsignedBigInteger('id_trabajador');
            $table->enum('tipo_movimiento', ['entrada', 'salida', 'ajuste']);
            $table->enum('referencia-tipo', ['venta', 'compra', 'merma', 'ajuste', 'otro'])->nullable();

            $table->unsignedBigInteger('referencia_id')->nullable();
            $table->integer('cantidad');
            $table->dateTime('fecha')->useCurrent();
            $table->text('motivo')->nullable();

            $table->foreign('id_producto')->references('id_producto')->on('productos')->onDelete('cascade');
            $table->foreign('id_sucursal')->references('id_sucursal')->on('sucursales')->onDelete('cascade');
            $table->foreign('id_trabajador')->references('id_trabajador')->on('trabajadores')->onDelete('cascade');

            $table->index('id_producto');
            $table->index('id_sucursal');



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimiento_inventarios');
    }
};
