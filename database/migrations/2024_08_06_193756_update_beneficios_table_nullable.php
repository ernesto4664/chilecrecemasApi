<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBeneficiosTableNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beneficios', function (Blueprint $table) {
            $table->unsignedBigInteger('region_id')->nullable()->change();
            $table->unsignedBigInteger('comuna_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('beneficios', function (Blueprint $table) {
            $table->unsignedBigInteger('region_id')->nullable(false)->change();
            $table->unsignedBigInteger('comuna_id')->nullable(false)->change();
        });
    }
}
