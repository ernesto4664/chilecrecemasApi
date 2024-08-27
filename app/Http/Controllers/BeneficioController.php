<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsuarioFamiliar;
use App\Models\Beneficio;
use App\Models\Etapa;
use App\Models\Comuna;
use App\Models\Region;
use App\Models\Ubicacion;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Services\EtapaService;

class BeneficioController extends Controller
{
    public function index()
    {
        try {
            $beneficios = Beneficio::with(['etapas', 'regiones', 'comunas', 'ubicaciones'])->get();
            return response()->json($beneficios);
        } catch (\Exception $e) {
            Log::error('Error al obtener los beneficios', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error al obtener los beneficios', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        // Definir reglas de validación
        $rules = [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'tipo_usuario' => 'required|string|in:Gestante,NN',
            'etapa_id' => 'required|array|min:1',
            'etapa_id.*' => 'integer|exists:etapas,id',
            'tipo_beneficio' => 'required|string|in:Salud,OLN,PARN,MADIS,Sala Cuna,Educacion,Municipal,Otro',
            'region_id' => 'required|array|min:1',
            'region_id.*' => 'integer|exists:regions,id',
            'comuna_id' => 'required|array|min:1',
            'comuna_id.*' => 'integer|exists:comunas,id',
            'ubicacion_id' => 'required|array|min:1',
            'ubicacion_id.*' => 'integer|exists:ubicaciones,id',
            'requisitos' => 'required|string',
            'vigencia' => 'required|date',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        // Validar la solicitud
        $validatedData = $request->validate($rules);

        // Consolas de depuración para verificar la validación
        Log::info('Datos validados:', $validatedData);

        // Determinar tipo_registro_id basado en tipo_usuario
        $tipoRegistroMap = [
            'Gestante' => 1,
            'NN' => 2,
        ];
        $validatedData['tipo_registro_id'] = $tipoRegistroMap[$validatedData['tipo_usuario']];

        // Consolas de depuración para verificar tipo_registro_id
        Log::info('Tipo registro ID:', ['id' => $validatedData['tipo_registro_id']]);

        // Manejo de la imagen
        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->store('images', 'public');
            $validatedData['imagen'] = '/storage/' . $imagePath;

            // Consola de depuración para verificar la imagen
            Log::info('Imagen cargada en:', ['path' => $validatedData['imagen']]);
        }

        // Iniciar transacción de base de datos
        DB::beginTransaction();

        try {
            // Crear el beneficio
            $beneficio = Beneficio::create([
                'nombre' => $validatedData['nombre'],
                'descripcion' => $validatedData['descripcion'],
                'tipo_usuario' => $validatedData['tipo_usuario'],
                'tipo_beneficio' => $validatedData['tipo_beneficio'],
                'requisitos' => $validatedData['requisitos'],
                'vigencia' => $validatedData['vigencia'],
                'tipo_registro_id' => $validatedData['tipo_registro_id'],
                'imagen' => $validatedData['imagen'] ?? null,
            ]);

            // Consolas de depuración para verificar la creación del beneficio
            Log::info('Beneficio creado:', $beneficio->toArray());

            // Sincronizar relaciones en tablas pivote
            $beneficio->etapas()->sync($validatedData['etapa_id']);
            $beneficio->regiones()->sync($validatedData['region_id']);
            $beneficio->comunas()->sync($validatedData['comuna_id']);
            $beneficio->ubicaciones()->sync($validatedData['ubicacion_id']);

            // Confirmar transacción
            DB::commit();

            Log::info('Beneficio guardado exitosamente');

            return response()->json([
                'message' => 'Beneficio creado exitosamente',
                'data' => $beneficio
            ], 201);

        } catch (\Exception $e) {
            // Revertir transacción en caso de error
            DB::rollBack();

            // Eliminar imagen cargada si ocurre un error
            if (isset($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            // Registrar error en logs
            Log::error('Error al crear el beneficio: ' . $e->getMessage());

            return response()->json([
                'message' => 'Error al crear el beneficio',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    


    public function show($id)
    {
        try {
            $beneficio = Beneficio::with(['etapas', 'ubicaciones', 'regiones', 'comunas'])->findOrFail($id);
            return response()->json($beneficio);
        } catch (\Exception $e) {
         //   Log::error('Error al obtener el beneficio: ', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error al obtener el beneficio', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        Log::info('Datos recibidos:', $request->all());
    
        $rules = [
            'region_id' => 'nullable|array',
            'region_id.*' => 'integer|exists:regions,id',
            'comuna_id' => 'nullable|array',
            'comuna_id.*' => 'integer|exists:comunas,id',
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
        \Log::info('Datos validados:', $validatedData);
    
        $beneficio = Beneficio::findOrFail($id);
    
        // Actualizar campos simples
        $beneficio->fill($validatedData);
    
        // Asignación de imagen
        if ($request->hasFile('imagen')) {
            if ($beneficio->imagen) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $beneficio->imagen));
            }
    
            $imagePath = $request->file('imagen')->store('images', 'public');
            $beneficio->imagen = '/storage/' . $imagePath;
            \Log::info('Imagen subida y asignada con path:', ['path' => $beneficio->imagen]);
        }
    
        $beneficio->save();
        \Log::info('Beneficio guardado:', $beneficio->toArray());
    
        // Sincronizar relaciones
        if (isset($validatedData['etapa_id'])) {
            $beneficio->etapas()->sync($validatedData['etapa_id']);
            \Log::info('Etapas sincronizadas:', ['etapas' => $validatedData['etapa_id']]);
        } else {
            $beneficio->etapas()->detach();
            \Log::info('Etapas removidas');
        }
    
        if (isset($validatedData['ubicacion_id'])) {
            $beneficio->ubicaciones()->sync($validatedData['ubicacion_id']);
            \Log::info('Ubicaciones sincronizadas:', ['ubicaciones' => $validatedData['ubicacion_id']]);
        } else {
            $beneficio->ubicaciones()->detach();
            \Log::info('Ubicaciones removidas');
        }
    
        if (isset($validatedData['region_id'])) {
            $beneficio->regiones()->sync($validatedData['region_id']);
            \Log::info('Regiones sincronizadas:', ['regions' => $validatedData['region_id']]);
        } else {
            $beneficio->regiones()->detach();
            \Log::info('Regiones removidas');
        }
    
        if (isset($validatedData['comuna_id'])) {
            $beneficio->comunas()->sync($validatedData['comuna_id']);
            \Log::info('Comunas sincronizadas:', ['comunas' => $validatedData['comuna_id']]);
        } else {
            $beneficio->comunas()->detach();
            \Log::info('Comunas removidas');
        }
    
        return response()->json([
            'message' => 'Beneficio actualizado exitosamente',
            'data' => $beneficio
        ]);
    }
    
    public function destroy($id)
    {
        try {
            $beneficio = Beneficio::findOrFail($id);
    
            $beneficio->comunas()->detach();
            $beneficio->regiones()->detach();
            $beneficio->etapas()->detach();
            $beneficio->ubicaciones()->detach();
    
            $beneficio->delete();
    
            return response()->json(['message' => 'Beneficio eliminado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar el beneficio', 'error' => $e->getMessage()], 500);
        }
    }

    public function getEtapasByTipoUsuario($tipo_usuario)
    {
        $etapas = Etapa::where('tipo_usuario', $tipo_usuario)->get();

      //  Log::info('Etapas obtenidas para tipo de usuario:', ['tipo_usuario' => $tipo_usuario, 'etapas' => $etapas]);

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

    public function getBenefitsByFamilyMember($id)
    {
        try {
            $familiar = UsuarioFamiliar::with(['comuna.region', 'etapa', 'usuario'])->findOrFail($id);
    
            // Obtener la comuna desde el usuario principal si la comuna del familiar no existe
            if (!$familiar->comuna) {
                $familiar->comuna = $familiar->usuario->comuna;
            }
    
            // Crear una instancia de EtapaService
            $etapaService = new EtapaService();
            
            // Obtener la etapa para el familiar
            $familiar->etapa_actual = $etapaService->obtenerEtapaUsuario($familiar);
    
            $beneficios = Beneficio::where('tipo_registro_id', $familiar->tipoderegistro_id)
                                    ->with(['etapas', 'regiones', 'comunas', 'ubicaciones'])
                                    ->get();
    
            return response()->json([
                'familiar' => $familiar,
                'beneficios' => $beneficios
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al obtener los beneficios: ' . $e->getMessage());
            return response()->json(['message' => 'Error al obtener los beneficios', 'error' => $e->getMessage()], 500);
        }
    }
}
