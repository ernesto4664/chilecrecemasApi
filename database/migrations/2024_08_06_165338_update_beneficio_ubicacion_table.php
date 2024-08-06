<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBeneficioUbicacionTable extends Migration
{
    /**
     * Ejecutar las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beneficio_ubicacion', function (Blueprint $table) {
            // Añadir columna id autoincrementable
            $table->id()->first(); // La columna id será la primera columna en la tabla

            // Quitar las claves foráneas existentes
            $table->dropForeign(['beneficio_id']);
            $table->dropForeign(['ubicacion_id']);

            // Volver a añadir las claves foráneas sin las restricciones de eliminación en cascada
            $table->foreign('beneficio_id')->references('id')->on('beneficios');
            $table->foreign('ubicacion_id')->references('id')->on('ubicaciones');
        });
    }

    /**
     * Revertir las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('beneficio_ubicacion', function (Blueprint $table) {
            // Eliminar la columna id
            $table->dropColumn('id');

            // Revertir las claves foráneas a su estado anterior
            $table->dropForeign(['beneficio_id']);
            $table->dropForeign(['ubicacion_id']);
            
            // Volver a añadir las claves foráneas con eliminación en cascada
            $table->foreign('beneficio_id')->references('id')->on('beneficios')->onDelete('cascade');
            $table->foreign('ubicacion_id')->references('id')->on('ubicaciones')->onDelete('cascade');
        });
    }
}
