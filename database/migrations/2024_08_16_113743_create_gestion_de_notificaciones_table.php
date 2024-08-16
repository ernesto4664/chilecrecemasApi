<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGestionDeNotificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gestion_de_notificaciones', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_notificacion', ['noticia', 'beneficio', 'OfertaMunicipal']);
            $table->unsignedBigInteger('contenido_id')->nullable(); // ID de la noticia o beneficio
            $table->string('target_audience')->default('todos'); // público objetivo: todos, registrados, no_registrados
            $table->timestamp('scheduled_time')->nullable(); // fecha y hora programada
            $table->enum('status', ['pendiente', 'enviada', 'programada'])->default('pendiente'); // estado de la notificación
            
            // Campos específicos para "OfertaMunicipal"
            $table->string('nombre')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('archivo')->nullable(); // Ruta al archivo subido
            $table->string('url')->nullable();
            $table->timestamp('fecha_creacion')->nullable();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->unsignedBigInteger('comuna_id')->nullable();

            $table->timestamps();

            // Foreign keys (puedes ajustarlas según tus tablas existentes)
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('set null');
            $table->foreign('comuna_id')->references('id')->on('comunas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gestion_de_notificaciones');
    }
}