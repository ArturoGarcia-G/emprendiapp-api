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
        Schema::table('inventario_movimientos', function (Blueprint $table) {
            $table->uuid('registro_autor_id')->nullable()->change();
            $table->uuid('actualizacion_autor_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventario_movimientos', function (Blueprint $table) {
            $table->unsignedBigInteger('registro_autor_id')->nullable()->change();
            $table->unsignedBigInteger('actualizacion_autor_id')->nullable()->change();
        });
    }
};
