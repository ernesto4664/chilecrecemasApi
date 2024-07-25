<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Etapa;
use App\Models\TipoDeRegistro;

class EtapasTableSeeder extends Seeder
{
    public function run()
    {
        // Eliminar registros en lugar de truncar
        Etapa::query()->delete();
        
        // Obtener los tipos de registro
        $gestante = TipoDeRegistro::where('nombre', 'gestante')->first();
        $pgestante = TipoDeRegistro::where('nombre', 'Pgestante')->first();
        $nino = TipoDeRegistro::where('nombre', 'nino')->first();

        // Llenar etapas para gestación
        if ($gestante && $pgestante) {
            Etapa::create([
                'nombre' => 'Gestacion 1er trimestre',
                'descripcion' => 'Descripción del primer trimestre de gestación',
                'tipo_registro_id' => $gestante->id,
                'semanas_embarazo_minima' => 1,
                'semanas_embarazo_maxima' => 12
            ]);

            Etapa::create([
                'nombre' => 'Gestacion 2do trimestre',
                'descripcion' => 'Descripción del segundo trimestre de gestación',
                'tipo_registro_id' => $gestante->id,
                'semanas_embarazo_minima' => 13,
                'semanas_embarazo_maxima' => 24
            ]);

            Etapa::create([
                'nombre' => 'Gestacion 3er trimestre',
                'descripcion' => 'Descripción del tercer trimestre de gestación',
                'tipo_registro_id' => $gestante->id,
                'semanas_embarazo_minima' => 25,
                'semanas_embarazo_maxima' => 36
            ]);

            // Para pgestante
            Etapa::create([
                'nombre' => 'Gestacion 1er trimestre',
                'descripcion' => 'Descripción del primer trimestre de gestación para Pgestante',
                'tipo_registro_id' => $pgestante->id,
                'semanas_embarazo_minima' => 1,
                'semanas_embarazo_maxima' => 12
            ]);

            Etapa::create([
                'nombre' => 'Gestacion 2do trimestre',
                'descripcion' => 'Descripción del segundo trimestre de gestación para Pgestante',
                'tipo_registro_id' => $pgestante->id,
                'semanas_embarazo_minima' => 13,
                'semanas_embarazo_maxima' => 24
            ]);

            Etapa::create([
                'nombre' => 'Gestacion 3er trimestre',
                'descripcion' => 'Descripción del tercer trimestre de gestación para Pgestante',
                'tipo_registro_id' => $pgestante->id,
                'semanas_embarazo_minima' => 25,
                'semanas_embarazo_maxima' => 36
            ]);
        }

        // Llenar etapas para niños
        if ($nino) {
            Etapa::create([
                'nombre' => 'Crecimiento 0 a 2 años',
                'descripcion' => 'Descripción del crecimiento de 0 a 2 años',
                'tipo_registro_id' => $nino->id,
                'edad_minima' => 0,
                'edad_maxima' => 2
            ]);

            Etapa::create([
                'nombre' => 'Crecimiento 3 a 6 años',
                'descripcion' => 'Descripción del crecimiento de 3 a 6 años',
                'tipo_registro_id' => $nino->id,
                'edad_minima' => 3,
                'edad_maxima' => 6
            ]);

            Etapa::create([
                'nombre' => 'Crecimiento 7 a 10 años',
                'descripcion' => 'Descripción del crecimiento de 7 a 10 años',
                'tipo_registro_id' => $nino->id,
                'edad_minima' => 7,
                'edad_maxima' => 10
            ]);
        }
    }
}
