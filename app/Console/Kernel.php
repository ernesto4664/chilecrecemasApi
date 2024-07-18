<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define los comandos de Artisan de la aplicación.
     *
     * @var array
     */
    protected $commands = [
        // Registrar comandos aquí
        \App\Console\Commands\UpdateFamilyMemberData::class,
    ];

    /**
     * Define la programación de los comandos.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('update:family-member-data')->daily();
    }

    /**
     * Registra los comandos de la aplicación.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
