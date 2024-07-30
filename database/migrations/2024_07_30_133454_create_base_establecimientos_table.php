<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaseEstablecimientosTable extends Migration
{
    public function up()
    {
        Schema::create('base_establecimientos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_antiguo');
            $table->string('codigo_vigente');
            $table->string('codigo_madre_antiguo');
            $table->string('codigo_madre_nuevo');
            $table->string('codigo_region');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('base_establecimientos');
    }
}
