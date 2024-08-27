<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyGestionDeNotificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gestion_de_notificaciones', function (Blueprint $table) {
            if (Schema::hasColumn('gestion_de_notificaciones', 'contenido_id')) {
                $table->dropColumn('contenido_id');
            }
            if (Schema::hasColumn('gestion_de_notificaciones', 'nombre')) {
                $table->dropColumn('nombre');
            }
            if (Schema::hasColumn('gestion_de_notificaciones', 'descripcion')) {
                $table->dropColumn('descripcion');
            }
            if (Schema::hasColumn('gestion_de_notificaciones', 'archivo')) {
                $table->dropColumn('archivo');
            }
            if (Schema::hasColumn('gestion_de_notificaciones', 'url')) {
                $table->dropColumn('url');
            }
            if (Schema::hasColumn('gestion_de_notificaciones', 'fecha_creacion')) {
                $table->dropColumn('fecha_creacion');
            }
            if (Schema::hasColumn('gestion_de_notificaciones', 'region_id')) {
                $table->dropColumn('region_id');
            }
            if (Schema::hasColumn('gestion_de_notificaciones', 'comuna_id')) {
                $table->dropColumn('comuna_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gestion_de_notificaciones', function (Blueprint $table) {
            // Añade las columnas nuevamente si es necesario
            $table->unsignedBigInteger('contenido_id')->nullable();
            $table->string('nombre')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('archivo')->nullable();
            $table->string('url')->nullable();
            $table->timestamp('fecha_creacion')->nullable();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->unsignedBigInteger('comuna_id')->nullable();
        });
    }
}
