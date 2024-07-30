<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficioEtapaTable extends Migration
{
    public function up()
    {
        Schema::create('beneficio_etapa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('beneficio_id');
            $table->unsignedBigInteger('etapa_id');
            $table->timestamps();

            $table->foreign('beneficio_id')->references('id')->on('beneficios')->onDelete('cascade');
            $table->foreign('etapa_id')->references('id')->on('etapas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('beneficio_etapa');
    }
}
