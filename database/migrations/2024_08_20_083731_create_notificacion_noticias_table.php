<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacionNoticiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificacion_noticias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notificacion_id'); // ID de la notificación en la tabla gestion_de_notificaciones
            $table->unsignedBigInteger('noticia_id'); // ID de la noticia
            $table->unsignedBigInteger('comuna_id'); // ID de la comuna

            $table->timestamps();

            // Foreign keys
            $table->foreign('notificacion_id')->references('id')->on('gestion_de_notificaciones')->onDelete('cascade');
            $table->foreign('noticia_id')->references('idnoticia')->on('noticia')->onDelete('cascade');
            $table->foreign('comuna_id')->references('id')->on('comunas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notificacion_noticias');
    }
}

