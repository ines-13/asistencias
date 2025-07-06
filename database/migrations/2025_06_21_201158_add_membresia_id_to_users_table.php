<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('membresia_id')->nullable()->after('notas_medicas');

            $table->foreign('membresia_id')
                  ->references('id_membresia')->on('membresias')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['membresia_id']);
            $table->dropColumn('membresia_id');
        });
    }
};
