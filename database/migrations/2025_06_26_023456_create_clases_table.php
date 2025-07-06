<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClasesTable extends Migration {
  public function up() {
    Schema::create('clases', function (Blueprint $t) {
      $t->id();
      $t->string('nombre');
      $t->string('nivel');
      $t->string('dia');
      $t->string('hora');
      $t->string('instructor');
      $t->timestamps();
    });
  }
  public function down() {
    Schema::dropIfExists('clases');
  }
}
