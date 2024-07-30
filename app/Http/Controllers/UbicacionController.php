<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ubicacion;

class UbicacionController extends Controller
{
    public function index()
    {
        $ubicaciones = Ubicacion::with(['beneficio', 'region', 'comuna'])->get();
        return response()->json($ubicaciones);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'beneficio_id' => 'required|integer|exists:beneficios,id',
            'region_id' => 'required|integer|exists:regiones,id',
            'comuna_id' => 'required|integer|exists:comunas,id',
            'tipo_establecimiento' => 'required|string|max:255',
            'nombre_establecimiento' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'horarios' => 'required|string|max:255',
            'contacto' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
            'id_establecimiento' => 'required|integer|exists:base_establecimientos,id',
        ]);

        $ubicacion = Ubicacion::create($validatedData);

        return response()->json(['message' => 'Ubicación creada exitosamente.', 'data' => $ubicacion], 201);
    }

    public function show($id)
    {
        $ubicacion = Ubicacion::with(['beneficio', 'region', 'comuna'])->findOrFail($id);
        return response()->json($ubicacion);
    }

    public function update(Request $request, $id)
    {
        \Log::info('Contenido de la solicitud (raw):', [$request->getContent()]);
        \Log::info('Contenido de la solicitud:', [$request->all()]);

        $rules = [
            'beneficio_id' => 'nullable|integer|exists:beneficios,id',
            'region_id' => 'nullable|integer|exists:regiones,id',
            'comuna_id' => 'nullable|integer|exists:comunas,id',
            'tipo_establecimiento' => 'nullable|string|max:255',
            'nombre_establecimiento' => 'nullable|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'horarios' => 'nullable|string|max:255',
            'contacto' => 'nullable|string|max:255',
            'lat' => 'nullable|numeric',
            'long' => 'nullable|numeric',
            'id_establecimiento' => 'nullable|integer|exists:base_establecimientos,id',
        ];

        $validatedData = $request->validate($rules);

        $ubicacion = Ubicacion::findOrFail($id);

        \Log::info('Datos recibidos para actualización:', $validatedData);
        \Log::info('Datos actuales de la ubicación antes de actualizar:', $ubicacion->toArray());

        foreach ($validatedData as $key => $value) {
            $ubicacion->$key = $value;
        }

        \Log::info('Datos de la ubicación después de asignar los valores pero antes de guardar:', $ubicacion->toArray());

        $ubicacion->save();

        \Log::info('Ubicación guardada:', $ubicacion->toArray());

        return response()->json([
            'message' => 'Ubicación actualizada exitosamente',
            'data' => $ubicacion
        ]);
    }

    public function destroy($id)
    {
        Ubicacion::destroy($id);
        return response()->json(null, 204);
    }
}

