<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Beneficio;
use App\Models\Etapa;
use App\Models\Comuna;
use App\Models\Region;
use App\Models\Ubicacion;
use App\Models\TipoDeRegistro;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BeneficioController extends Controller
{
    public function index()
    {
        $beneficios = Beneficio::with(['region', 'comuna', 'tipoRegistro', 'etapas', 'ubicaciones'])->get();
        return response()->json($beneficios);
    }

    public function store(Request $request)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'tipo_usuario' => 'required|string',
            'etapa_id' => 'required|array',
            'etapa_id.*' => 'integer|exists:etapas,id',
            'tipo_beneficio' => 'required|string',
            'region_id' => 'required|integer|exists:regions,id',
            'comuna_id' => 'required|integer|exists:comunas,id',
            'ubicacion_id' => 'required|array',
            'ubicacion_id.*' => 'integer|exists:ubicaciones,id',
            'requisitos' => 'required|string',
            'vigencia' => 'required|date',
            'imagen' => 'required|image|max:2048',
        ]);

        // Manejar la imagen
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('images', 'public');
            $validatedData['imagen'] = $path;
        }

        // Asignar tipo_registro_id basado en tipo_usuario
        if ($validatedData['tipo_usuario'] === 'Gestante') {
            $validatedData['tipo_registro_id'] = [1, 3];
        } elseif ($validatedData['tipo_usuario'] === 'NN') {
            $validatedData['tipo_registro_id'] = [2];
        }

        // Crear múltiples registros de beneficio con tipo_registro_id y guardar relaciones en la tabla pivote
        foreach ($validatedData['tipo_registro_id'] as $tipoRegistroId) {
            $beneficioData = $validatedData;
            $beneficioData['tipo_registro_id'] = $tipoRegistroId;

            $beneficio = Beneficio::create($beneficioData);

            // Guardar las relaciones en la tabla pivote beneficio_etapa
            $beneficio->etapas()->attach($validatedData['etapa_id']);

            // Guardar las relaciones en la tabla pivote beneficio_ubicacion
            $beneficio->ubicaciones()->attach($validatedData['ubicacion_id']);
        }

        return response()->json(['message' => 'Beneficio creado exitosamente'], 201);
    }

    public function show($id)
    {
        $beneficio = Beneficio::with(['region', 'comuna', 'tipoRegistro', 'etapas', 'ubicaciones'])->findOrFail($id);
        return response()->json($beneficio);
    }

    public function update(Request $request, $id)
    {
        Log::info('Contenido de la solicitud (raw):', [$request->getContent()]);
        Log::info('Contenido de la solicitud:', [$request->all()]);

        $rules = [
            'region_id' => 'required|exists:regions,id',
            'comuna_id' => 'nullable|integer|exists:comunas,id',
            'tipo_usuario' => 'nullable|string|max:255',
            'etapa_id' => 'nullable|array',
            'etapa_id.*' => 'integer|exists:etapas,id',
            'tipo_beneficio' => 'nullable|string|max:255',
            'nombre' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'requisitos' => 'nullable|string',
            'vigencia' => 'nullable|date',
            'ubicacion_id' => 'nullable|array',
            'ubicacion_id.*' => 'integer|exists:ubicaciones,id',
        ];

        if ($request->hasFile('imagen')) {
            $rules['imagen'] = 'image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        $validatedData = $request->validate($rules);

        Log::info('Datos validados para actualización:', $validatedData);

        $beneficio = Beneficio::findOrFail($id);

        Log::info('Datos actuales del beneficio antes de actualizar:', $beneficio->toArray());

        if (isset($validatedData['tipo_usuario'])) {
            if ($validatedData['tipo_usuario'] === 'gestante') {
                $validatedData['tipo_registro_id'] = 1;
            } elseif ($validatedData['tipo_usuario'] === 'NN') {
                $validatedData['tipo_registro_id'] = 2;
            } else {
                Log::error('Tipo de usuario inválido:', ['tipo_usuario' => $validatedData['tipo_usuario']]);
                return response()->json(['error' => 'Tipo de usuario inválido.'], 400);
            }
        }

        foreach ($validatedData as $key => $value) {
            if ($key !== 'imagen') {
                $beneficio->$key = $value;
            }
        }

        if ($request->hasFile('imagen')) {
            if ($beneficio->imagen) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $beneficio->imagen));
            }

            $imagePath = $request->file('imagen')->store('images', 'public');
            $beneficio->imagen = '/storage/' . $imagePath;
            Log::info('Imagen actualizada:', ['path' => $beneficio->imagen]);
        }

        Log::info('Datos del beneficio después de asignar los valores pero antes de guardar:', $beneficio->toArray());

        $beneficio->save();

        if (isset($validatedData['etapa_id'])) {
            $beneficio->etapas()->sync($validatedData['etapa_id']);
            Log::info('Etapas relacionadas:', ['etapa_id' => $validatedData['etapa_id']]);
        }

        if (isset($validatedData['ubicacion_id'])) {
            $beneficio->ubicaciones()->sync($validatedData['ubicacion_id']);
            Log::info('Ubicaciones relacionadas:', ['ubicacion_id' => $validatedData['ubicacion_id']]);
        }

        Log::info('Beneficio actualizado:', $beneficio->toArray());

        return response()->json([
            'message' => 'Beneficio actualizado exitosamente',
            'data' => $beneficio
        ]);
    }

    public function destroy($id)
    {
        Beneficio::destroy($id);
        Log::info('Beneficio eliminado:', ['id' => $id]);
        return response()->json(null, 204);
    }

    public function getEtapasByTipoUsuario($tipo_usuario)
    {
        if ($tipo_usuario === 'gestante') {
            $etapas = Etapa::whereIn('id', [1, 3])->get();
        } elseif ($tipo_usuario === 'NN') {
            $etapas = Etapa::where('id', 2)->get();
        } else {
            Log::error('Tipo de usuario inválido:', ['tipo_usuario' => $tipo_usuario]);
            return response()->json(['error' => 'Tipo de usuario inválido.'], 400);
        }

        Log::info('Etapas obtenidas para tipo de usuario:', ['tipo_usuario' => $tipo_usuario, 'etapas' => $etapas]);

        return response()->json($etapas);
    }

    public function getBeneficiosByEtapa($etapa_id)
    {
        $beneficios = Beneficio::whereHas('etapas', function($query) use ($etapa_id) {
            $query->where('etapa_id', $etapa_id);
        })->with(['region', 'comuna', 'tipoRegistro', 'etapas', 'ubicaciones'])->get();

        return response()->json($beneficios);
    }

    public function filterByRegionComuna(Request $request)
    {
        try {
            $regionId = $request->input('region_id');
            $comunaId = $request->input('comuna_id');
    
            $query = Beneficio::with(['region', 'comuna', 'tipoRegistro', 'etapas', 'ubicaciones']);
    
            if ($regionId) {
                $query->where('region_id', $regionId);
            }
    
            if ($comunaId) {
                $query->where('comuna_id', $comunaId);
            }
    
            $beneficios = $query->get();
    
            return response()->json($beneficios, 200);
        } catch (\Exception $e) {
            Log::error('Error al filtrar beneficios por región y comuna: ' . $e->getMessage());
            return response()->json(['error' => 'Error al filtrar beneficios'], 500);
        }
    }
}
