<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BaseEstablecimiento;

class BaseEstablecimientoController extends Controller
{
    public function index()
    {
        $baseEstablecimientos = BaseEstablecimiento::all();
        return response()->json($baseEstablecimientos);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'codigo_antiguo' => 'required|string|max:255',
            'codigo_vigente' => 'required|string|max:255',
            'codigo_madre_antiguo' => 'required|string|max:255',
            'codigo_madre_nuevo' => 'required|string|max:255',
            'codigo_region' => 'required|string|max:255',
        ]);

        $baseEstablecimiento = BaseEstablecimiento::create($validatedData);

        return response()->json(['message' => 'Base de Establecimiento creada exitosamente.', 'data' => $baseEstablecimiento], 201);
    }

    public function show($id)
    {
        $baseEstablecimiento = BaseEstablecimiento::findOrFail($id);
        return response()->json($baseEstablecimiento);
    }

    public function update(Request $request, $id)
    {
        \Log::info('Contenido de la solicitud (raw):', [$request->getContent()]);
        \Log::info('Contenido de la solicitud:', [$request->all()]);

        $rules = [
            'codigo_antiguo' => 'nullable|string|max:255',
            'codigo_vigente' => 'nullable|string|max:255',
            'codigo_madre_antiguo' => 'nullable|string|max:255',
            'codigo_madre_nuevo' => 'nullable|string|max:255',
            'codigo_region' => 'nullable|string|max:255',
        ];

        $validatedData = $request->validate($rules);

        $baseEstablecimiento = BaseEstablecimiento::findOrFail($id);

        \Log::info('Datos recibidos para actualización:', $validatedData);
        \Log::info('Datos actuales del baseEstablecimiento antes de actualizar:', $baseEstablecimiento->toArray());

        foreach ($validatedData as $key => $value) {
            $baseEstablecimiento->$key = $value;
        }

        \Log::info('Datos del baseEstablecimiento después de asignar los valores pero antes de guardar:', $baseEstablecimiento->toArray());

        $baseEstablecimiento->save();

        \Log::info('Base de Establecimiento guardada:', $baseEstablecimiento->toArray());

        return response()->json([
            'message' => 'Base de Establecimiento actualizada exitosamente',
            'data' => $baseEstablecimiento
        ]);
    }

    public function destroy($id)
    {
        BaseEstablecimiento::destroy($id);
        return response()->json(null, 204);
    }
}
