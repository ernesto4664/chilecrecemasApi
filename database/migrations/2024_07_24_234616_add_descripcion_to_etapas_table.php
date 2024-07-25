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
        Schema::table('etapas', function (Blueprint $table) {
            $table->text('descripcion')->nullable(); // Puedes cambiar 'nullable' según tus necesidades
        });
    }
    
    public function down()
    {
        Schema::table('etapas', function (Blueprint $table) {
            $table->dropColumn('descripcion');
        });
    }
};
