<?php

namespace App\Http\Controllers;

use App\Models\UsuarioFamiliar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UsuarioFamiliarController extends Controller
{
    public function index()
    {
        try {
            $userId = Auth::id();
            Log::info('Obteniendo familiares para el usuario con ID: ' . $userId);
            $familiares = UsuarioFamiliar::where('usuarioP_id', $userId)->get();
            Log::info('Familiares obtenidos: ' . $familiares->toJson());
            return response()->json($familiares, 200);
        } catch (\Exception $e) {
            Log::error('Error al obtener familiares: ' . $e->getMessage());
            return response()->json(['error' => 'Error al obtener familiares'], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'edad' => 'required|integer|min:0',
            'sexo' => 'required|string|in:M,F,O',
            'fecha_nacimiento' => 'required|date',
            'semanas_embarazo' => 'nullable|integer|min:0',
            'parentesco' => 'required|string|max:255',
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
            'edad' => 'required|integer|min:0',
            'sexo' => 'required|string|in:M,F,O',
            'fecha_nacimiento' => 'required|date',
            'semanas_embarazo' => 'nullable|integer|min:0',
            'parentesco' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            Log::error('Error de validación al actualizar familiar: ' . json_encode($validator->errors()));
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $userId = Auth::id();
            Log::info('Actualizando familiar para el usuario con ID: ' . $userId);
            $familiar = UsuarioFamiliar::where('usuarioP_id', $userId)->findOrFail($id);

            $familiar->update($request->all());
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
