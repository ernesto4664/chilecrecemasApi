<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsuariopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('usuariop', function (Blueprint $table) {
            $table->dropColumn('edad');
            $table->date('fecha_nacimiento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usuariop', function (Blueprint $table) {
            $table->integer('edad')->nullable();
            $table->dropColumn('fecha_nacimiento');
        });
    }
}
