<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveEtapaIdFromBeneficiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beneficios', function (Blueprint $table) {
            $table->dropForeign(['etapa_id']); // Eliminar la restricción de clave foránea
            $table->dropColumn('etapa_id');    // Eliminar la columna
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('beneficios', function (Blueprint $table) {
            $table->unsignedBigInteger('etapa_id')->nullable();

            // Restaurar la restricción de clave foránea
            $table->foreign('etapa_id')->references('id')->on('etapas')->onDelete('cascade');
        });
    }
}
