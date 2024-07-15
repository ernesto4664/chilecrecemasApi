<?php

namespace App\Http\Controllers;

use App\Models\UsuarioFamiliar;
use App\Models\UsuarioP;
use App\Models\SemanasEmbarazo;
use App\Models\EdadFamiliar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class UsuarioFamiliarController extends Controller
{
    public function index()
    {
        try {
            $userId = Auth::id();
            Log::info('Obteniendo familiares para el usuario con ID: ' . $userId);
            $familiares = UsuarioFamiliar::with(['semanasEmbarazo'])->where('usuarioP_id', $userId)->get();
            Log::info('Familiares obtenidos: ' . $familiares->toJson());
            return response()->json($familiares, 200);
        } catch (\Exception $e) {
            Log::error('Error al obtener familiares: ' . $e->getMessage());
            return response()->json(['error' => 'Error al obtener familiares'], 500);
        }
    }

    public function getAllUsersWithFamilies()
    {
        $usuarios = UsuarioP::with('familiares')->get();
        return view('admin.usuariosApp.users-with-families', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'tipo_registro' => 'string',
            'sexo' => 'string|in:M,F,O',
            'fecha_nacimiento' => 'date',
            'semanas_embarazo_id' => 'nullable|exists:semanas_embarazos,id',
            'parentesco' => 'string|max:255',
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
            $data['edad'] = Carbon::parse($request->fecha_nacimiento)->age; // Calcula la edad a partir de la fecha de nacimiento

            // Proporcionar un valor por defecto para 'parentesco' si no está presente
            if (!isset($data['parentesco'])) {
                $data['parentesco'] = 'No aplica';
            }

            $familiar = UsuarioFamiliar::create($data);
            Log::info('Familiar añadido: ' . $familiar->toJson());
            return response()->json($familiar, 201);
        } catch (\Exception $e) {
            Log::error('Error al añadir familiar: ' . $e->getMessage());
            return response()->json(['error' => 'Error al añadir familiar'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'tipo_registro' => 'string', // Asegúrate de validar este campo
            'sexo' => 'string|in:M,F,O',
            'fecha_nacimiento' => 'date',
            'semanas_embarazo_id' => 'nullable|exists:semanas_embarazos,id',
            'parentesco' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            Log::error('Error de validación al actualizar familiar: ' . json_encode($validator->errors()));
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $userId = Auth::id();
            Log::info('Actualizando familiar para el usuario con ID: ' . $userId);
            $familiar = UsuarioFamiliar::where('usuarioP_id', $userId)->findOrFail($id);

            $data = $request->all();
            $data['edad'] = Carbon::parse($request->fecha_nacimiento)->age; // Calcula la edad a partir de la fecha de nacimiento

                // Proporcionar un valor por defecto para 'parentesco' si no está presente
                if (!isset($data['parentesco'])) {
                    $data['parentesco'] = 'No aplica';
                }

            $familiar->update($data);
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
            Log::info('Eliminando familiar para el usuario con ID: ' . $userId);
            $familiar = UsuarioFamiliar::where('usuarioP_id', $userId)->findOrFail($id);

            $familiar->delete();
            Log::info('Familiar eliminado: ' . $familiar->toJson());
            return response()->json(['message' => 'Familiar eliminado correctamente'], 200);
        } catch (\Exception $e) {
            Log::error('Error al eliminar familiar: ' . $e->getMessage());
            return response()->json(['error' => 'Error al eliminar familiar'], 500);
        }
    }
}
