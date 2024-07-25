<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEtapaactualIdToUsuarioFamiliarsTable extends Migration
{
    public function up()
    {
        Schema::table('usuario_familiars', function (Blueprint $table) {
            $table->unsignedBigInteger('etapaactual_id')->nullable()->after('tipoderegistro_id');

            // Assuming `etapas` is the table name for the Etapa model
            $table->foreign('etapaactual_id')->references('id')->on('etapas')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('usuario_familiars', function (Blueprint $table) {
            $table->dropForeign(['etapaactual_id']);
            $table->dropColumn('etapaactual_id');
        });
    }
}