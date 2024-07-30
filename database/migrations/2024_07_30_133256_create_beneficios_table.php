<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficiosTable extends Migration
{
    public function up()
    {
        Schema::create('beneficios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('region_id');
            $table->unsignedBigInteger('comuna_id');
            $table->unsignedBigInteger('tipo_registro_id');
            $table->unsignedBigInteger('etapa_id');
            $table->string('tipo_usuario');
            $table->string('tipo_beneficio');
            $table->string('nombre');
            $table->text('descripcion');
            $table->text('requisitos');
            $table->string('imagen')->nullable();
            $table->date('vigencia');
            $table->timestamps();

            // Definir claves foráneas
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->foreign('comuna_id')->references('id')->on('comunas')->onDelete('cascade');
            $table->foreign('tipo_registro_id')->references('id')->on('tipos_de_registro')->onDelete('cascade');
            $table->foreign('etapa_id')->references('id')->on('etapas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('beneficios');
    }
}

