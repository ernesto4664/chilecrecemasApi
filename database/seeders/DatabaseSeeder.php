<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RegionsTableSeeder::class,
            ComunasTableSeeder::class,
            SemanasEmbarazosSeeder::class,
            EtapasTableSeeder::class,
            TipoDeRegistroSeeder::class,
        ]);
    }
}
