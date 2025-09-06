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
            $table->uuid('producto_id')->primary();
            $table->smallInteger('folio');
            $table->string('sku', 50)->nullable();
            $table->string('nombre', 255);
            $table->integer('stock');
            $table->decimal('precio', 14, 2);
            $table->string('costo', 14, 2);
            $table->string('status', 50)->default('activo');
            $table->timestamp('registro_fecha');
			$table->unsignedBigInteger('registro_autor_id');
			$table->timestamp('actualizacion_fecha')->nullable();
			$table->unsignedBigInteger('actualizacion_autor_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
