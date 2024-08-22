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

    public function getUbicacionesByRegionsAndComunas(Request $request)
    {
        $regionIds = (array) $request->input('regionIds', []);
        $comunaIds = (array) $request->input('comunaIds', []);
    
        if (count($regionIds) === 0 || count($comunaIds) === 0) {
            return response()->json(['message' => 'Debe proporcionar al menos una región y una comuna.'], 400);
        }
    
        $ubicaciones = Ubicacion::whereIn('region_id', $regionIds)
                                ->whereIn('comuna_id', $comunaIds)
                                ->get();
    
        return response()->json($ubicaciones);
    }

    public function getComunasByRegions(Request $request)
    {
        try {
            $regionIds = $request->input('regionIds');
            
            if (is_array($regionIds) && !empty($regionIds)) {
                $comunas = Comuna::whereIn('region_id', $regionIds)->get();
                return response()->json($comunas);
            } else {
                return response()->json(['error' => 'No region IDs provided'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
