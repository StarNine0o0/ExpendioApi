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
        Schema::create('mermas', function (Blueprint $table) {
            $table->id('id_merma');
            $table->unsignedBigInteger('id_trabajador');
            $table->unsignedBigInteger('id_producto');
            $table->unsignedBigInteger('id_sucursal');
            $table->dateTime('fecha')->useCurrent();
            $table->integer('cantidad');
            $table->text('motivo')->nullable();
            $table->decimal('costo_merma', 10, 2);

            $table->foreign('id_trabajador')->references('id_trabajador')->on('trabajadores')->onDelete('cascade');
            $table->foreign('id_producto')->references('id_producto')->on('productos')->onDelete('cascade');
            $table->foreign('id_sucursal')->references('id_sucursal')->on('sucursales')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mermas');
    }
};
