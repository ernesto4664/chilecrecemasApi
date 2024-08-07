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
        try {
            // Cargar beneficios con sus relaciones
            $beneficios = Beneficio::with(['etapas', 'regiones', 'comunas', 'ubicaciones'])->get();
            return response()->json($beneficios);
        } catch (\Exception $e) {
            // Registrar el error
            \Log::error('Error al obtener los beneficios', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error al obtener los beneficios', 'error' => $e->getMessage()], 500);
        }
    }
    public function store(Request $request)
    {
        // Registrar el inicio del proceso
        Log::info('Iniciando el proceso de creación de beneficio', ['request' => $request->all()]);
    
        try {
            // Obtener los IDs de la solicitud
            $etapaIds = $request->input('etapa_id', []);
            $regionIds = $request->input('region_id', []);
            $comunaIds = $request->input('comuna_id', []);
            $ubicacionIds = $request->input('ubicacion_id', []);
    
            // Verificar si los IDs existen en sus respectivas tablas
            $etapasExist = \DB::table('etapas')->whereIn('id', $etapaIds)->pluck('id')->toArray();
            $regionsExist = \DB::table('regions')->whereIn('id', $regionIds)->pluck('id')->toArray();
            $comunasExist = \DB::table('comunas')->whereIn('id', $comunaIds)->pluck('id')->toArray();
            $ubicacionesExist = \DB::table('ubicaciones')->whereIn('id', $ubicacionIds)->pluck('id')->toArray();
    
            Log::info('Verificación de IDs', [
                'etapa_ids' => $etapaIds,
                'etapas_exist' => $etapasExist,
                'region_ids' => $regionIds,
                'regions_exist' => $regionsExist,
                'comuna_ids' => $comunaIds,
                'comunas_exist' => $comunasExist,
                'ubicacion_ids' => $ubicacionIds,
                'ubicaciones_exist' => $ubicacionesExist
            ]);
    
            if (count($etapasExist) !== count($etapaIds) ||
                count($regionsExist) !== count($regionIds) ||
                count($comunasExist) !== count($comunaIds) ||
                count($ubicacionesExist) !== count($ubicacionIds)) {
                return response()->json(['message' => 'Uno o más IDs no existen en las tablas correspondientes'], 422);
            }
    
            // Validar los datos recibidos
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'tipo_usuario' => 'required|string',
                'etapa_id' => 'required|array',
                'etapa_id.*' => 'integer|exists:etapas,id',
                'tipo_beneficio' => 'required|string',
                'region_id' => 'required|array',
                'region_id.*' => 'integer|exists:regions,id',
                'comuna_id' => 'required|array',
                'comuna_id.*' => 'integer|exists:comunas,id',
                'ubicacion_id' => 'required|array',
                'ubicacion_id.*' => 'integer|exists:ubicaciones,id',
                'requisitos' => 'required|string',
                'vigencia' => 'required|date',
                'imagen' => 'nullable|file|mimes:jpg,jpeg,png',
            ]);
    
            // Registrar los datos validados
            Log::info('Datos validados', ['validatedData' => $validatedData]);
    
            // Manejar la imagen
            $imagePath = null;
            if ($request->hasFile('imagen')) {
                $imagePath = $request->file('imagen')->store('images', 'public');
                Log::info('Imagen guardada en', ['path' => $imagePath]);
            }
    
            // Asignar tipo_registro_id basado en tipo_usuario
            $tipoRegistroIds = [];
            if ($validatedData['tipo_usuario'] === 'Gestante') {
                $tipoRegistroIds = [1, 3];
            } elseif ($validatedData['tipo_usuario'] === 'NN') {
                $tipoRegistroIds = [2];
            }
            Log::info('Tipo de registro asignado', ['tipoRegistroIds' => $tipoRegistroIds]);
    
            // Crear múltiples registros de beneficio y guardar relaciones en la tabla pivote
            foreach ($tipoRegistroIds as $tipoRegistroId) {
                $beneficioData = $validatedData;
                $beneficioData['tipo_registro_id'] = $tipoRegistroId;
                $beneficioData['imagen'] = $imagePath;
    
                // Crear el beneficio con tipo_registro_id
                $beneficio = Beneficio::create($beneficioData);
                Log::info('Beneficio creado', ['beneficio' => $beneficio]);
    
                // Guardar las relaciones en la tabla pivote beneficio_etapa
                if (!empty($validatedData['etapa_id'])) {
                    $beneficio->etapas()->attach($validatedData['etapa_id']);
                    Log::info('Relaciones etapa guardadas', ['etapa_id' => $validatedData['etapa_id']]);
                }
    
                // Guardar las relaciones en la tabla pivote beneficio_ubicacion
                if (!empty($validatedData['ubicacion_id'])) {
                    $beneficio->ubicaciones()->attach($validatedData['ubicacion_id']);
                    Log::info('Relaciones ubicación guardadas', ['ubicacion_id' => $validatedData['ubicacion_id']]);
                }
    
                // Guardar relaciones en otras tablas pivote si es necesario
                if (!empty($validatedData['region_id'])) {
                    $beneficio->regiones()->attach($validatedData['region_id']);
                    Log::info('Relaciones región guardadas', ['region_id' => $validatedData['region_id']]);
                }
    
                if (!empty($validatedData['comuna_id'])) {
                    $beneficio->comunas()->attach($validatedData['comuna_id']);
                    Log::info('Relaciones comuna guardadas', ['comuna_id' => $validatedData['comuna_id']]);
                }
            }
    
            Log::info('Beneficio creado exitosamente');
            return response()->json(['message' => 'Beneficio creado exitosamente'], 201);
    
        } catch (\Exception $e) {
            // Registrar el error y mostrar mensaje
            Log::error('Error al crear el beneficio', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error al guardar el beneficio', 'error' => $e->getMessage()], 422);
        }
    }

    public function show($id)
    {
        try {
            $beneficio = Beneficio::with(['etapas', 'ubicaciones', 'regiones', 'comunas'])->findOrFail($id);
            return response()->json($beneficio);
        } catch (\Exception $e) {
            Log::error('Error al obtener el beneficio: ', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error al obtener el beneficio', 'error' => $e->getMessage()], 500);
        }
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
        try {
            $beneficio = Beneficio::findOrFail($id);
    
            // Eliminar relaciones en tablas pivote
            $beneficio->comunas()->detach();
            $beneficio->regiones()->detach();
            $beneficio->etapas()->detach();
            $beneficio->ubicaciones()->detach();
    
            // Ahora eliminar el beneficio
            $beneficio->delete();
    
            return response()->json(['message' => 'Beneficio eliminado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar el beneficio', 'error' => $e->getMessage()], 500);
        }
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
