<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoderegistroIdToUsuarioFamiliarsTable extends Migration
{
    public function up()
    {
        Schema::table('usuario_familiars', function (Blueprint $table) {
            $table->unsignedBigInteger('tipoderegistro_id')->nullable();
            $table->foreign('tipoderegistro_id')->references('id')->on('tipos_de_registro');
            $table->dropColumn('tipo_registro');
        });
    }

    public function down()
    {
        Schema::table('usuario_familiars', function (Blueprint $table) {
            $table->dropForeign(['tipoderegistro_id']);
            $table->dropColumn('tipoderegistro_id');
            $table->string('tipo_registro');
        });
    }
}
