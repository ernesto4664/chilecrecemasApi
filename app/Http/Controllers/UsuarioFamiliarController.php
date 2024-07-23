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
            foreach ($familiares as $familiar) {
                if ($familiar->fecha_nacimiento) {
                    $familiar->edad = Carbon::parse($familiar->fecha_nacimiento)->age;
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
            // Obtener usuarios con sus familiares, semanas de embarazo, región y comuna
            $usuarios = UsuarioP::with(['familiares.semanasEmbarazo', 'region', 'comuna'])->get();

            // Devolver los usuarios en formato JSON
            return response()->json(['data' => $usuarios], 200);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => 'Error al obtener los usuarios y sus familiares'], 500);
        }
    }

    public function store(Request $request)
    {
        Log::info('Datos recibidos para añadir familiar: ' . json_encode($request->all()));
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'sexo' => 'string|max:1',
            'fecha_nacimiento' => 'required|date',
            'semanas_embarazo_id' => 'nullable|integer',
            'parentesco' => 'nullable|string|max:255',
            'tipoderegistro_id' => 'integer',
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
            Log::info('Familiar añadido: ' . $familiar->toJson());
            return response()->json($familiar, 201);
        } catch (\Exception $e) {
            Log::error('Error al añadir familiar: ' . $e->getMessage());
            return response()->json(['error' => 'Error al añadir familiar'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // Log the received data for updating a family member
        Log::info('Datos recibidos para actualizar familiar: ' . json_encode($request->all()));
    
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'nombres' => 'string|max:255',
            'apellidos' => 'string|max:255',
            'sexo' => 'string|max:1',
            'fecha_nacimiento' => 'date',
            'semanas_embarazo_id' => 'nullable|integer',
            'parentesco' => 'nullable|string|max:255',
            'tipoderegistro_id' => 'integer',
            'usuarioP_id' => 'integer'
        ]);
    
        // If validation fails, log the errors and return a 422 response
        if ($validator->fails()) {
            Log::error('Error de validación al actualizar familiar: ' . json_encode($validator->errors()));
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        try {
            // Get the authenticated user's ID
            $userId = Auth::id();
            Log::info('Actualizando familiar para el usuario con ID: ' . $userId);
    
            // Find the family member by ID and user ID
            $familiar = UsuarioFamiliar::where('usuarioP_id', $userId)->findOrFail($id);
    
            // Get the validated data
            $data = $validator->validated();
    
            // Calculate the age from the birthdate
            $data['edad'] = Carbon::parse($data['fecha_nacimiento'])->age;
    
            // Provide a default value for 'parentesco' if not present
            if (!isset($data['parentesco'])) {
                $data['parentesco'] = 'No aplica';
            }
    
            // Update the family member with the validated data
            $familiar->update($data);
            Log::info('Familiar actualizado: ' . $familiar->toJson());
    
            // Return a 200 response with the updated family member
            return response()->json($familiar, 200);
        } catch (\Exception $e) {
            // Log any exception that occurs during the update process
            Log::error('Error al actualizar familiar: ' . $e->getMessage());
    
            // Return a 500 response if an error occurs
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
