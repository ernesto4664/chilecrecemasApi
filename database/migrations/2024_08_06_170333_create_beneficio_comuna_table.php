<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficioComunaTable extends Migration
{
    /**
     * Ejecutar las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficio_comuna', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('beneficio_id');
            $table->unsignedBigInteger('comuna_id');
            $table->timestamps();

            // Definir claves foráneas
            $table->foreign('beneficio_id')->references('id')->on('beneficios');
            $table->foreign('comuna_id')->references('id')->on('comunas');
        });
    }

    /**
     * Revertir las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beneficio_comuna');
    }
}
