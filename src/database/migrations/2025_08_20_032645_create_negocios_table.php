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
        Schema::create('negocios', function (Blueprint $table) {
            $table->uuid('negocio_id')->primary();
            $table->string('nombre', 255);
            $table->string('email', 255)->nullable();
            $table->string('telefono', 50)->nullable();
            $table->string('direccion', 500)->nullable();
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
        Schema::dropIfExists('negocios');
    }
};
