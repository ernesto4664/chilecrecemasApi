<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noticia', function (Blueprint $table) {
            $table->id('idnoticia');
            $table->string('titulo', 45)->nullable();
            $table->text('descripcion')->nullable();
            $table->text('imagen')->nullable();
            $table->dateTime('fecha_hora')->nullable();
            $table->string('status', 45)->nullable();
            $table->string('privilegio', 45)->nullable();
            $table->unsignedBigInteger('tags_idtags');
            $table->unsignedBigInteger('usuariop_id');
            $table->foreign('tags_idtags')->references('idtags')->on('tags')->onDelete('no action')->onUpdate('no action');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('noticia');
    }
};
