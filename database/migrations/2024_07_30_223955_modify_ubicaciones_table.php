<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUbicacionesTable extends Migration
{
    public function up()
    {
        Schema::table('ubicaciones', function (Blueprint $table) {
            if (Schema::hasColumn('ubicaciones', 'beneficio_id')) {
                $table->dropForeign(['beneficio_id']);
                $table->dropColumn('beneficio_id');
            }
            if (!Schema::hasColumn('ubicaciones', 'fk_beneficio')) {
                $table->string('fk_beneficio');
            }
        });
    }

    public function down()
    {
        Schema::table('ubicaciones', function (Blueprint $table) {
            if (Schema::hasColumn('ubicaciones', 'fk_beneficio')) {
                $table->dropColumn('fk_beneficio');
            }
            if (!Schema::hasColumn('ubicaciones', 'beneficio_id')) {
                $table->unsignedBigInteger('beneficio_id');
                $table->foreign('beneficio_id')->references('id')->on('beneficios')->onDelete('cascade');
            }
        });
    }
}
