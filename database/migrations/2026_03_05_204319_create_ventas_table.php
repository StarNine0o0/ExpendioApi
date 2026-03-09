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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id('id_venta');
            $table->unsignedBigInteger('id_trabajador');
            $table->unsignedBigInteger('id_caja');
            $table->unsignedBigInteger('id_metodo_pago');
            $table->DateTime('fecha')->useCurrent();
            $table->decimal('descuento_porcentaje', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->decimal('monto_recibido', 10, 2);
            $table->enum('estado', ['pendiente', 'completada', 'cancelada'])->default('pendiente');
            
            $table->foreign('id_trabajador')->references('id_trabajador')->on('trabajadores')->onUpdate('cascade');
            $table->foreign('id_caja')->references('id_caja')->on('cajas')->onUpdate('cascade');
            $table->foreign('id_metodo_pago')->references('id_metodo_pago')->on('metodos_pago')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
