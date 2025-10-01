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
        Schema::create('inventario_movimientos', function (Blueprint $table) {
            $table->uuid('inventario_movimiento_id')->primary();
            $table->uuid('producto_id');
            $table->uuid('venta_id')->nullable();
            $table->integer('cantidad');
            $table->string('descripcion', 255);
            $table->enum('tipo', ['alta', 'baja']);
            $table->timestamp('registro_fecha');
            $table->unsignedBigInteger('registro_autor_id');
            $table->timestamp('actualizacion_fecha')->nullable();
            $table->unsignedBigInteger('actualizacion_autor_id')->nullable();
            $table->uuid('negocio_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario_movimientos');
    }
};
