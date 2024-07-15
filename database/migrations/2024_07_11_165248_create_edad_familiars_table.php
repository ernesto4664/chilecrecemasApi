<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('edad_familiars', function (Blueprint $table) {
            $table->id();
            $table->string('edad');
            $table->timestamps();
        });

                // Insertar los datos de edades
                DB::table('edad_familiars')->insert([
                    ['id' => 1, 'edad' => '1 mes'],
                    ['id' => 2, 'edad' => '2 meses'],
                    ['id' => 3, 'edad' => '3 meses'],
                    ['id' => 4, 'edad' => '4 meses'],
                    ['id' => 5, 'edad' => '5 meses'],
                    ['id' => 6, 'edad' => '6 meses'],
                    ['id' => 7, 'edad' => '7 meses'],
                    ['id' => 8, 'edad' => '8 meses'],
                    ['id' => 9, 'edad' => '9 meses'],
                    ['id' => 10, 'edad' => '10 meses'],
                    ['id' => 11, 'edad' => '11 meses'],
                    ['id' => 12, 'edad' => '1 año'],
                    ['id' => 13, 'edad' => '2 años'],
                    ['id' => 14, 'edad' => '3 años'],
                    ['id' => 15, 'edad' => '4 años'],
                    ['id' => 16, 'edad' => '5 años'],
                    ['id' => 17, 'edad' => '6 años'],
                    ['id' => 18, 'edad' => '7 años'],
                    ['id' => 19, 'edad' => '8 años'],
                    ['id' => 20, 'edad' => '9 años'],
                    ['id' => 21, 'edad' => '10 años'],
                ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edad_familiars');
    }
};
