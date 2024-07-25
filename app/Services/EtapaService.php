<?php

namespace App\Services;

use App\Models\Etapa;
use App\Models\UsuarioFamiliar;
use Illuminate\Support\Facades\Log;

class EtapaService
{
    public function obtenerEtapaUsuario(UsuarioFamiliar $familiar)
    {
        if ($familiar->tipoderegistro_id == 1 || $familiar->tipoderegistro_id == 3) {
            $semanasEmbarazoId = $familiar->semanas_embarazo_id;
            Log::info('ID de semanas de embarazo: ' . $semanasEmbarazoId);
            if ($semanasEmbarazoId !== null) {
                $etapa = Etapa::where('tipo_registro_id', 1)
                            ->where('semanas_embarazo_minima', '<=', $semanasEmbarazoId)
                            ->where('semanas_embarazo_maxima', '>=', $semanasEmbarazoId)
                            ->first();
                Log::info('Etapa encontrada: ' . json_encode($etapa));
                return $etapa;
            }
        }

        if ($familiar->tipoderegistro_id == 2) {
            $edad = $familiar->edad ?? null;
            Log::info('Edad: ' . $edad);
            if ($edad !== null) {
                $etapa = Etapa::where('tipo_registro_id', $familiar->tipoderegistro_id)
                            ->where('edad_minima', '<=', $edad)
                            ->where('edad_maxima', '>=', $edad)
                            ->first();
                Log::info('Etapa encontrada: ' . json_encode($etapa));
                return $etapa;
            }
        }

        Log::info('No se encontró etapa para el usuario');
        return null;
    }
}
