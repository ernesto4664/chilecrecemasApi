<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyLatLongToStringInUbicacionesTable extends Migration
{
    public function up()
    {
        Schema::table('ubicaciones', function (Blueprint $table) {
            // Cambiar lat y long a tipo string
            $table->string('lat')->change();
            $table->string('long')->change();
        });
    }

    public function down()
    {
        Schema::table('ubicaciones', function (Blueprint $table) {
            // Revertir cambios
            $table->decimal('lat', 10, 7)->change();
            $table->decimal('long', 10, 7)->change();
        });
    }
}
