<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUbicacionesTable extends Migration
{
    public function up()
    {
        Schema::create('ubicaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('beneficio_id');
            $table->unsignedBigInteger('region_id');
            $table->unsignedBigInteger('comuna_id');
            $table->string('tipo_establecimiento');
            $table->string('nombre_establecimiento');
            $table->string('direccion');
            $table->string('horarios');
            $table->string('contacto');
            $table->decimal('lat', 10, 7);
            $table->decimal('long', 10, 7);
            $table->unsignedBigInteger('id_establecimiento');
            $table->timestamps();

            $table->foreign('beneficio_id')->references('id')->on('beneficios')->onDelete('cascade');
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->foreign('comuna_id')->references('id')->on('comunas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ubicaciones');
    }
}
