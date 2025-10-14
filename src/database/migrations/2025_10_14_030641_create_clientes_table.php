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
        Schema::create('clientes', function (Blueprint $table) {
            $table->uuid('cliente_id')->primary();
            $table->smallInteger('folio_local');
            $table->smallInteger('folio_global');
            $table->string('telefono', 12);
            $table->string('nombre', 255);
            $table->string('status', 50)->default('activo');
            $table->timestamp('registro_fecha');
			$table->uuid('registro_autor_id');
			$table->timestamp('actualizacion_fecha')->nullable();
			$table->uuid('actualizacion_autor_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
