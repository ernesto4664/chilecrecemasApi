<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSemanasEmbarazoField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('usuario_familiars', function (Blueprint $table) {
            $table->unsignedBigInteger('semanas_embarazo_id')->nullable()->after('fecha_nacimiento');
            $table->dropColumn('semanas_embarazo');
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
            $table->integer('semanas_embarazo')->nullable()->after('fecha_nacimiento');
            $table->dropColumn('semanas_embarazo_id');
        });
    }
}
