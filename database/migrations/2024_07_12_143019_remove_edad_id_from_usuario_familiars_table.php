<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveEdadIdFromUsuarioFamiliarsTable extends Migration
{
    public function up()
    {
        Schema::table('usuario_familiars', function (Blueprint $table) {
            $table->dropForeign(['edad_id']); // Elimina la restricción de clave foránea
            $table->dropColumn('edad_id'); // Elimina la columna
        });
    }

    public function down()
    {
        Schema::table('usuario_familiars', function (Blueprint $table) {
            $table->unsignedBigInteger('edad_id')->nullable();
            $table->foreign('edad_id')->references('id')->on('edad_familiars')->onDelete('cascade'); // Agrega la clave foránea en caso de revertir la migración
        });
    }
}
