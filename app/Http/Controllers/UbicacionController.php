<?php

namespace App\Http\Controllers;

use App\Models\Ubicacion;
use App\Models\Region;
use App\Models\Comuna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class UbicacionController extends Controller
{
    public function index()
    {
        $ubicaciones = Ubicacion::with(['region', 'comuna', 'baseEstablecimiento'])->get();
        return response()->json($ubicaciones);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fk_beneficio' => 'string',
            'region_id' => 'required|array',
            'comuna_id' => 'required|array',
            'tipo_establecimiento' => 'string',
            'nombre_establecimiento' => 'required|string',
            'direccion' => 'nullable|string',
            'horarios' => 'nullable|string',
            'contacto' => 'nullable|string',
            'lat' => 'nullable|string', // Cambiado a numeric si es necesario
            'long' => 'nullable|string', // Cambiado a numeric si es necesario
            'codigo_madre_nuevo' => 'required|string',
            'id_establecimiento' => 'required|integer',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        $ubicacionData = $request->all();
        $ubicacionData['region_id'] = implode(',', $request->region_id); // Convertir a cadena
        $ubicacionData['comuna_id'] = implode(',', $request->comuna_id); // Convertir a cadena
    
        try {
            $ubicacion = Ubicacion::create($ubicacionData);
            return response()->json($ubicacion, 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar la ubicación: ' . $e->getMessage());
            return response()->json(['error' => 'Error al guardar la ubicación'], 500);
        }
    }
    
    public function show($id)
    {
        $ubicacion = Ubicacion::with(['beneficio', 'baseEstablecimiento'])->findOrFail($id);
        return response()->json($ubicacion);
    }
    
    public function update(Request $request, $id)
    {
        Log::info('Datos recibidos en update:', $request->all());
    
        try {
            $validatedData = $request->validate([
                'fk_beneficio' => 'sometimes|required|string|max:255',
                'region_id' => 'sometimes|required|exists:regions,id',
                'comuna_id' => 'sometimes|required|exists:comunas,id',
                'tipo_establecimiento' => 'sometimes|required|string|max:255',
                'nombre_establecimiento' => 'sometimes|required|string|max:255',
                'direccion' => 'sometimes|required|string|max:255',
                'horarios' => 'sometimes|required|string|max:255',
                'contacto' => 'sometimes|required|string|max:255',
                'lat' => 'sometimes|required|string|max:255',
                'long' => 'sometimes|required|string|max:255',
                'id_establecimiento' => 'sometimes|required|exists:base_establecimientos,id',
            ]);
    
            Log::info('Datos validados en update:', $validatedData);
    
            $ubicacion = Ubicacion::findOrFail($id);
            $ubicacion->update($validatedData);
            return response()->json($ubicacion);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación en update:', $e->errors());
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error al actualizar la ubicación:', $e->getMessage());
            return response()->json(['error' => 'Error al actualizar la ubicación'], 500);
        }
    }
    
    public function destroy($id)
    {
        $ubicacion = Ubicacion::findOrFail($id);
        $ubicacion->delete();
        return response()->json(null, 204);
    }

    // Método para obtener comunas basadas en regiones
    public function getComunasByRegions(Request $request)
    {
        $regionIds = $request->input('region_ids');
    
        // Verificar que $regionIds no es null o vacío
        if (is_array($regionIds) && count($regionIds) > 0) {
            $comunas = Comuna::whereIn('region_id', $regionIds)->get();
            return response()->json(['comunas' => $comunas]);
        } else {
            // Retornar una respuesta vacía o un error
            return response()->json(['comunas' => []], 200);
        }
    }
    
    // Método para obtener ubicaciones basadas en regiones y comunas
    public function getUbicacionesByRegionsAndComunas(Request $request)
    {
        $regionIds = $request->input('region_ids');
        $comunaIds = $request->input('comuna_ids');
    
        // Validación de entrada
        if (is_array($regionIds) && !empty($regionIds) && is_array($comunaIds) && !empty($comunaIds)) {
            $regionIds = array_map('intval', $regionIds);
            $comunaIds = array_map('intval', $comunaIds);
    
            // Filtrar ubicaciones que coincidan con cada par de region_id y comuna_id
            $ubicaciones = Ubicacion::whereIn('region_id', $regionIds)
                                    ->whereIn('comuna_id', $comunaIds)
                                    ->get();
    
            // Verificación adicional para asegurarse de que los resultados sean exactos
            $ubicaciones = $ubicaciones->filter(function ($ubicacion) use ($regionIds, $comunaIds) {
                return in_array($ubicacion->region_id, $regionIds) && in_array($ubicacion->comuna_id, $comunaIds);
            });
    
            return response()->json($ubicaciones->values());
        } else {
            return response()->json(['error' => 'Invalid region or comuna IDs'], 400);
        }
    }

    public function getAllRegionsWithComunasAndUbicaciones()
{
    $regions = Region::with(['comunas.ubicaciones'])->get();
    return response()->json($regions);
}

}
