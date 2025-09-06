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
		Schema::create('usuarios', function (Blueprint $table) {
			$table->uuid('usuario_id')->primary();
			$table->string('nombre_completo');
			$table->string('usuario')->unique();
			$table->string('password');
			$table->enum('status', ['activo', 'eliminado']);

			$table->timestamp('registro_fecha')->nullable();
			$table->unsignedBigInteger('registro_autor_id')->nullable();
			$table->timestamp('actualizacion_fecha')->nullable();
			$table->unsignedBigInteger('actualizacion_autor_id')->nullable();

			$table->string('id_negocio');

			$table->index('id_negocio');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('usuarios');
	}
};
