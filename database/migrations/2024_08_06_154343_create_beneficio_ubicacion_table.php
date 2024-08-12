<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficioUbicacionTable extends Migration
{
    /**
     * Ejecutar las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficio_ubicacion', function (Blueprint $table) {
            $table->unsignedBigInteger('beneficio_id');
            $table->unsignedBigInteger('ubicacion_id');

            $table->foreign('beneficio_id')->references('id')->on('beneficios')->onDelete('cascade');
            $table->foreign('ubicacion_id')->references('id')->on('ubicaciones')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Revertir las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beneficio_ubicacion');
    }
}
