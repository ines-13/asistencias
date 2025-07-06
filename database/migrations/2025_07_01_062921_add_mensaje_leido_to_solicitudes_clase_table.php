<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('solicitudes_clase', function (Blueprint $table) {
            $table->string('mensaje_cliente')->nullable();
            $table->boolean('leido_cliente')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('solicitudes_clase', function (Blueprint $table) {
            $table->dropColumn('mensaje_cliente');
            $table->dropColumn('leido_cliente');
        });
    }
};
