<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receta', function (Blueprint $table) {
            $table->increments('id_Receta');
            $table->string('url')->unique();
            $table->string('titulo');
            $table->string('texto');
            $table->string('categoria');
            $table->integer('comentarios');
            $table->integer('comentarios_positivos');
            $table->integer('comentarios_neutros');
            $table->integer('comentarios_negativos');
            $table->double('sentimiento');
            $table->double('nutriscore');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receta');
    }
};
