<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoRegistroToUsuarioFamiliarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('usuario_familiars', function (Blueprint $table) {
            $table->string('tipo_registro')->nullable(); // Añadir la columna tipo_registro
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usuario_familiars', function (Blueprint $table) {
            $table->dropColumn('tipo_registro');
        });
    }
}
