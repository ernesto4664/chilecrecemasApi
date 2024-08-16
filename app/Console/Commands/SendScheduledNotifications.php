<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\NotificacionController;

class SendScheduledNotifications extends Command
{
    // El nombre y la descripción del comando
    protected $signature = 'notificaciones:enviar-programadas';
    protected $description = 'Envía las notificaciones programadas que están listas para ser enviadas';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Instancia el controlador y llama al método sendScheduledNotifications
        $controller = new NotificacionController();
        $controller->sendScheduledNotifications();

        $this->info('Notificaciones programadas enviadas correctamente.');
    }
}