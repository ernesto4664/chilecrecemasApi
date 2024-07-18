<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UsuarioFamiliar;
use Carbon\Carbon;

class UpdateFamilyMemberData extends Command
{
    protected $signature = 'update:family-member-data';
    protected $description = 'Actualizar la edad y las semanas de embarazo de los miembros de la familia';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $familiares = UsuarioFamiliar::all();

        foreach ($familiares as $familiar) {
            // Actualizar la edad de los niños
            if ($familiar->fecha_nacimiento) {
                $familiar->edad = Carbon::parse($familiar->fecha_nacimiento)->age;
            }

            // Actualizar las semanas de embarazo
            if ($familiar->semanas_embarazo_id) {
                $familiar->semanas_embarazo_id += 1;
            }

            $familiar->save();
        }

        $this->info('Datos de los miembros de la familia actualizados exitosamente.');
    }
}
