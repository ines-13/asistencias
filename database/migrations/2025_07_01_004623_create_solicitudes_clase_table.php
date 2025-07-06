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
    Schema::create('solicitudes_clase', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('clase_id');
        $table->unsignedBigInteger('cliente_id');
        $table->enum('estado', ['pendiente', 'aceptada', 'rechazada'])->default('pendiente');
        $table->timestamps();

        // Llaves foráneas
        $table->foreign('clase_id')->references('id')->on('clases')->onDelete('cascade');
        $table->foreign('cliente_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes_clase');
    }
};
