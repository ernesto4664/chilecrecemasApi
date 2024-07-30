<?php

namespace App\Http\Controllers;

use App\Models\Etapa;
use App\Models\TipoDeRegistro;
use App\Services\EtapaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class EtapaController extends Controller
{
    protected $etapaService;

    public function __construct(EtapaService $etapaService)
    {
        $this->etapaService = $etapaService;
    }

    public function index()
    {
        $etapas = Etapa::with('tipoDeRegistro')->get();
        return response()->json($etapas, 200);
    }

    public function store(Request $request)
    {
        Log::info('Datos recibidos para crear etapa: ' . json_encode($request->all()));
    
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'tipo_registro_id' => 'required|integer|in:1,2,3',
            'edad_minima' => 'nullable|integer|min:0',
            'edad_maxima' => 'nullable|integer|min:0',
            'semanas_embarazo_minima' => 'nullable|integer|min:0',
            'semanas_embarazo_maxima' => 'nullable|integer|min:0',
            'etapa' => 'required|string|max:255'
        ]);
    
        if ($validator->fails()) {
            Log::error('Error de validación al crear etapa: ' . json_encode($validator->errors()));
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        try {
            $data = $validator->validated();
    
            // Unificar tipos de registro 1 y 3 bajo 'Gestación'
            if (in_array($data['tipo_registro_id'], [1, 3])) {
                $data['etapa'] = 'Gestación';
            } elseif ($data['tipo_registro_id'] == 2) {
                $data['etapa'] = 'Crecimiento';
            }
    
            $etapa = Etapa::create($data);
            Log::info('Etapa creada: ' . $etapa->toJson());
            return response()->json($etapa, 201);
        } catch (\Exception $e) {
            Log::error('Error al crear etapa: ' . $e->getMessage());
            return response()->json(['error' => 'Error al crear etapa'], 500);
        }
    }

    public function show(Etapa $etapa)
    {
        return response()->json($etapa->load('tipoDeRegistro'), 200);
    }

    public function edit(Etapa $etapa)
    {
        // Retornar vista para editar una etapa (si aplica para web)
    }

    public function update(Request $request, Etapa $etapa)
    {
        Log::info('Datos recibidos para actualizar etapa: ' . json_encode($request->all()));
    
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'tipo_registro_id' => 'required|integer|in:1,2,3',
            'edad_minima' => 'nullable|integer|min:0',
            'edad_maxima' => 'nullable|integer|min:0',
            'semanas_embarazo_minima' => 'nullable|integer|min:0',
            'semanas_embarazo_maxima' => 'nullable|integer|min:0',
            'etapa' => 'required|string|max:255'
        ]);
    
        if ($validator->fails()) {
            Log::error('Error de validación al actualizar etapa: ' . json_encode($validator->errors()));
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        try {
            $data = $validator->validated();
    
            // Unificar tipos de registro 1 y 3 bajo 'Gestación'
            if (in_array($data['tipo_registro_id'], [1, 3])) {
                $data['etapa'] = 'Gestación';
            } elseif ($data['tipo_registro_id'] == 2) {
                $data['etapa'] = 'Crecimiento';
            }
    
            $etapa->update($data);
            Log::info('Etapa actualizada: ' . $etapa->toJson());
            return response()->json($etapa, 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar etapa: ' . $e->getMessage());
            return response()->json(['error' => 'Error al actualizar etapa'], 500);
        }
    }

    public function destroy(Etapa $etapa)
    {
        try {
            $etapa->delete();
            Log::info('Etapa eliminada: ' . $etapa->toJson());
            return response()->json(['message' => 'Etapa eliminada correctamente'], 200);
        } catch (\Exception $e) {
            Log::error('Error al eliminar etapa: ' . $e->getMessage());
            return response()->json(['error' => 'Error al eliminar etapa'], 500);
        }
    }

    public function getUsuariosConFamiliares()
    {
        $usuarios = Usuario::with(['region', 'comuna', 'familiares'])->get();

        foreach ($usuarios as $usuario) {
            foreach ($usuario->familiares as $familiar) {
                // Determinar la etapa del familiar
                if (in_array($familiar->tipoderegistro_id, [1, 3])) {
                    $familiar->etapa = 'Gestación';
                } elseif ($familiar->tipoderegistro_id == 2) {
                    $familiar->etapa = 'Crecimiento';
                } else {
                    $familiar->etapa = 'No definida';
                }
            }
        }

        return response()->json($usuarios, 200);
    }

    public function getEtapasByTipoUsuario($tipoUsuario)
    {
        // Determinar el ID del tipo de registro basado en el tipo de usuario
        $tipoRegistroIds = [];
        if ($tipoUsuario === 'Gestante') {
            $tipoRegistroIds = [1, 3];
        } elseif ($tipoUsuario === 'NN') {
            $tipoRegistroIds = [2];
        } else {
            return response()->json([], 404); // No encontrado si el tipo de usuario no es válido
        }

        // Obtener etapas relacionadas con los IDs del tipo de registro
        $etapas = Etapa::whereIn('tipo_registro_id', $tipoRegistroIds)->get();
        return response()->json($etapas);
    }
}

