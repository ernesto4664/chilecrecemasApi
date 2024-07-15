<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTituloLengthInNoticiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('noticia', function (Blueprint $table) {
            $table->string('titulo', 500)->change(); // Cambiar el tamaño de la columna `titulo` a 500 caracteres
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('noticia', function (Blueprint $table) {
            $table->string('titulo', 255)->change(); // Revertir el tamaño de la columna `titulo` a 255 caracteres
        });
    }
}

