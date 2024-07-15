<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEdadColumnInUsuarioFamiliarsTable extends Migration
{
    public function up()
    {
        Schema::table('usuario_familiars', function (Blueprint $table) {
            $table->unsignedBigInteger('edad_id')->nullable()->after('edad');
            $table->foreign('edad_id')->references('id')->on('edad_familiars');
            $table->dropColumn('edad');
        });
    }

    public function down()
    {
        Schema::table('usuario_familiars', function (Blueprint $table) {
            $table->integer('edad')->after('edad_id');
            $table->dropForeign(['edad_id']);
            $table->dropColumn('edad_id');
        });
    }
}
