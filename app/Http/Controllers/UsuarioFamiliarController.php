<?php

namespace App\Http\Controllers;

use App\Models\UsuarioFamiliar;
use App\Models\UsuarioP;
use App\Services\EtapaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class UsuarioFamiliarController extends Controller
{
    protected $etapaService;

    public function __construct(EtapaService $etapaService)
    {
        $this->etapaService = $etapaService;
    }

    public function index()
    {
        try {
            $userId = Auth::id();
            Log::info('Obteniendo familiares para el usuario con ID: ' . $userId);
            $familiares = UsuarioFamiliar::with(['semanasEmbarazo', 'tipoDeRegistro', 'etapa'])->where('usuarioP_id', $userId)->get();
            foreach ($familiares as $familiar) {
                if ($familiar->fecha_nacimiento) {
                    $familiar->edad = Carbon::parse($familiar->fecha_nacimiento)->age;
                    $familiar->etapa_actual = $this->etapaService->obtenerEtapaUsuario($familiar);
                }
            }
            Log::info('Familiares obtenidos: ' . $familiares->toJson());
            return response()->json($familiares, 200);
        } catch (\Exception $e) {
            Log::error('Error al obtener familiares: ' . $e->getMessage());
            return response()->json(['error' => 'Error al obtener familiares'], 500);
        }
    }

    public function getAllUsersWithFamilies()
    {
        try {
            $usuarios = UsuarioP::with(['familiares.semanasEmbarazo', 'region', 'comuna'])->get();

            foreach ($usuarios as $usuario) {
                foreach ($usuario->familiares as $familiar) {
                    // Obtener la etapa del familiar dinámicamente
                    $etapa = $this->etapaService->obtenerEtapaUsuario($familiar);
                    $familiar->etapa = $etapa ? $etapa->nombre : 'No definida';
                }
            }

            return response()->json(['data' => $usuarios], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener los usuarios y sus familiares'], 500);
        }
    }


    public function store(Request $request)
    {
        Log::info('Datos recibidos para añadir familiar: ' . json_encode($request->all()));
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'sexo' => 'nullable|string|max:1',
            'fecha_nacimiento' => 'required|date',
            'semanas_embarazo_id' => 'nullable|integer',
            'parentesco' => 'nullable|string|max:255',
            'tipoderegistro_id' => 'required|integer|in:1,2',
            'usuarioP_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            Log::error('Error de validación al añadir familiar: ' . json_encode($validator->errors()));
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $userId = Auth::id();
            Log::info('Añadiendo familiar para el usuario con ID: ' . $userId);
            $data = $request->all();
            $data['usuarioP_id'] = $userId;
            $data['edad'] = Carbon::parse($request->fecha_nacimiento)->age;

            if (!isset($data['parentesco'])) {
                $data['parentesco'] = 'No aplica';
            }

            $familiar = UsuarioFamiliar::create($data);
            Log::info('Datos del familiar antes de obtener etapa: ' . $familiar->toJson());
            $etapa = $this->etapaService->obtenerEtapaUsuario($familiar);
            Log::info('Etapa obtenida: ' . json_encode($etapa));
            $familiar->etapaactual_id = $etapa->id ?? null;
            $familiar->save();

            Log::info('Familiar añadido: ' . $familiar->toJson());
            return response()->json($familiar, 201);
        } catch (\Exception $e) {
            Log::error('Error al añadir familiar: ' . $e->getMessage());
            return response()->json(['error' => 'Error al añadir familiar'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        Log::info('Datos recibidos para actualizar familiar: ' . json_encode($request->all()));

        $validator = Validator::make($request->all(), [
            'nombres' => 'string|max:255',
            'apellidos' => 'string|max:255',
            'sexo' => 'string|max:1',
            'fecha_nacimiento' => 'date',
            'semanas_embarazo_id' => 'nullable|integer',
            'parentesco' => 'nullable|string|max:255',
            'tipoderegistro_id' => 'integer|in:1,2',
            'usuarioP_id' => 'integer'
        ]);

        if ($validator->fails()) {
            Log::error('Error de validación al actualizar familiar: ' . json_encode($validator->errors()));
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $userId = Auth::id();
            Log::info('Actualizando familiar para el usuario con ID: ' . $userId);

            $familiar = UsuarioFamiliar::where('usuarioP_id', $userId)->findOrFail($id);
            $data = $validator->validated();
            $data['edad'] = Carbon::parse($data['fecha_nacimiento'])->age;

            if (!isset($data['parentesco'])) {
                $data['parentesco'] = 'No aplica';
            }

            $familiar->update($data);
            $familiar->etapa_actual = $this->etapaService->obtenerEtapaUsuario($familiar);
            $familiar->etapaactual_id = $familiar->etapa_actual->id ?? null;
            $familiar->save();

            Log::info('Familiar actualizado: ' . $familiar->toJson());
            return response()->json($familiar, 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar familiar: ' . $e->getMessage());
            return response()->json(['error' => 'Error al actualizar familiar'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $userId = Auth::id();
            Log::info('Eliminando familiar con ID: ' . $id . ' para el usuario con ID: ' . $userId);

            $familiar = UsuarioFamiliar::where('usuarioP_id', $userId)->findOrFail($id);
            $familiar->delete();

            Log::info('Familiar eliminado con ID: ' . $id);
            return response()->json(['message' => 'Familiar eliminado'], 200);
        } catch (\Exception $e) {
            Log::error('Error al eliminar familiar: ' . $e->getMessage());
            return response()->json(['error' => 'Error al eliminar familiar'], 500);
        }
    }
}
