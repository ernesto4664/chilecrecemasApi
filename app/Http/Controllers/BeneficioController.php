<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Beneficio;
use App\Models\Etapa;
use App\Models\Region;
use App\Models\Comuna;
use App\Models\Ubicacion;
use App\Models\BaseEstablecimiento;
use Illuminate\Support\Facades\Storage;

class BeneficioController extends Controller
{
    public function index()
    {
        $beneficios = Beneficio::with(['region', 'comuna', 'tipoRegistro', 'etapa', 'ubicaciones'])->get();
        return response()->json($beneficios);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'region_id' => 'required|integer|exists:regiones,id',
            'comuna_id' => 'required|integer|exists:comunas,id',
            'tipo_usuario' => 'required|string|max:255',
            'etapa_id' => 'required|array',
            'etapa_id.*' => 'integer|exists:etapas,id',
            'tipo_beneficio' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'requisitos' => 'required|string',
            'imagen' => 'nullable|image|max:2048',
            'vigencia' => 'required|date',
        ]);

        // Asignar tipo_registro_id según tipo_usuario
        if ($validatedData['tipo_usuario'] === 'gestante') {
            $validatedData['tipo_registro_id'] = 1; // o 3, según la lógica de tu aplicación
        } elseif ($validatedData['tipo_usuario'] === 'NN') {
            $validatedData['tipo_registro_id'] = 2;
        } else {
            return response()->json(['error' => 'Tipo de usuario inválido.'], 400);
        }

        $beneficio = new Beneficio();
        $beneficio->region_id = $validatedData['region_id'];
        $beneficio->comuna_id = $validatedData['comuna_id'];
        $beneficio->tipo_registro_id = $validatedData['tipo_registro_id'];
        $beneficio->tipo_usuario = $validatedData['tipo_usuario'];
        $beneficio->tipo_beneficio = $validatedData['tipo_beneficio'];
        $beneficio->nombre = $validatedData['nombre'];
        $beneficio->descripcion = $validatedData['descripcion'];
        $beneficio->requisitos = $validatedData['requisitos'];
        $beneficio->vigencia = $validatedData['vigencia'];

        // Manejar la imagen
        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->store('images', 'public');
            $beneficio->imagen = '/storage/' . $imagePath;
        }

        $beneficio->save();

        // Relacionar las etapas
        $beneficio->etapas()->sync($validatedData['etapa_id']);

        return response()->json(['message' => 'Beneficio creado exitosamente.', 'data' => $beneficio], 201);
    }

    public function show($id)
    {
        $beneficio = Beneficio::with(['region', 'comuna', 'tipoRegistro', 'etapa', 'ubicaciones'])->findOrFail($id);
        return response()->json($beneficio);
    }

    public function update(Request $request, $id)
    {
        \Log::info('Contenido de la solicitud (raw):', [$request->getContent()]);
        \Log::info('Contenido de la solicitud:', [$request->all()]);

        $rules = [
            'region_id' => 'nullable|integer|exists:regiones,id',
            'comuna_id' => 'nullable|integer|exists:comunas,id',
            'tipo_usuario' => 'nullable|string|max:255',
            'etapa_id' => 'nullable|array',
            'etapa_id.*' => 'integer|exists:etapas,id',
            'tipo_beneficio' => 'nullable|string|max:255',
            'nombre' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'requisitos' => 'nullable|string',
            'vigencia' => 'nullable|date',
        ];

        if ($request->hasFile('imagen')) {
            $rules['imagen'] = 'image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        $validatedData = $request->validate($rules);

        $beneficio = Beneficio::findOrFail($id);

        \Log::info('Datos recibidos para actualización:', $validatedData);
        \Log::info('Datos actuales del beneficio antes de actualizar:', $beneficio->toArray());

        // Asignar tipo_registro_id según tipo_usuario
        if (isset($validatedData['tipo_usuario'])) {
            if ($validatedData['tipo_usuario'] === 'gestante') {
                $validatedData['tipo_registro_id'] = 1; // o 3, según la lógica de tu aplicación
            } elseif ($validatedData['tipo_usuario'] === 'NN') {
                $validatedData['tipo_registro_id'] = 2;
            } else {
                return response()->json(['error' => 'Tipo de usuario inválido.'], 400);
            }
        }

        foreach ($validatedData as $key => $value) {
            if ($key !== 'imagen') {
                $beneficio->$key = $value;
            }
        }

        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($beneficio->imagen) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $beneficio->imagen));
            }

            $imagePath = $request->file('imagen')->store('images', 'public');
            $beneficio->imagen = '/storage/' . $imagePath;
        }

        \Log::info('Datos del beneficio después de asignar los valores pero antes de guardar:', $beneficio->toArray());

        $beneficio->save();

        // Relacionar las etapas
        if (isset($validatedData['etapa_id'])) {
            $beneficio->etapas()->sync($validatedData['etapa_id']);
        }

        \Log::info('Beneficio guardado:', $beneficio->toArray());

        return response()->json([
            'message' => 'Beneficio actualizado exitosamente',
            'data' => $beneficio
        ]);
    }

    public function destroy($id)
    {
        Beneficio::destroy($id);
        return response()->json(null, 204);
    }

    // Método para obtener etapas según tipo de usuario
    public function getEtapasByTipoUsuario($tipo_usuario)
    {
        if ($tipo_usuario === 'gestante') {
            $etapas = Etapa::whereIn('id', [1, 3])->get();
        } elseif ($tipo_usuario === 'NN') {
            $etapas = Etapa::where('id', 2)->get();
        } else {
            return response()->json(['error' => 'Tipo de usuario inválido.'], 400);
        }

        return response()->json($etapas);
    }
}
