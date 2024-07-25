<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('etapas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('tipo_registro_id')->constrained('tipos_de_registro');
            $table->integer('edad_minima')->nullable();
            $table->integer('edad_maxima')->nullable();
            $table->integer('semanas_embarazo_minima')->nullable();
            $table->integer('semanas_embarazo_maxima')->nullable();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('etapas');
    }
};
