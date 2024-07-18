<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoDeRegistroSeeder extends Seeder
{
    public function run()
    {
        DB::table('tipos_de_registro')->insert([
            ['nombre' => 'gestante'],
            ['nombre' => 'nino'],
            ['nombre' => 'Pgestante'],
        ]);
    }
}