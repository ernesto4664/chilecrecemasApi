<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficioRegionTable extends Migration
{
    /**
     * Ejecutar las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficio_region', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('beneficio_id');
            $table->unsignedBigInteger('region_id');
            $table->timestamps();

            // Definir claves foráneas
            $table->foreign('beneficio_id')->references('id')->on('beneficios')->onDelete('cascade');
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
        });
    }

    /**
     * Revertir las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beneficio_region');
    }
}
