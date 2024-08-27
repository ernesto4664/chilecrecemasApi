<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;


use App\Models\NotificacionNoticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NotificacionController extends Controller
{
    // Mostrar todas las notificaciones
    public function index()
    {
        $notificaciones = Notificacion::with(['region', 'comuna', 'noticia', 'beneficio'])->get();
        return response()->json($notificaciones);
    }

// Crear una nueva notificación
public function store(Request $request)
{
    Log::info('Solicitud de creación de notificación recibida', ['data' => $request->all()]);
    // Valida los datos recibidos
    $validatedData = $request->validate([
    'tipoNotificacion' => 'required|in:noticia,beneficio,OfertaMunicipal',
    'noticias' => 'array',
    'regionIds' => 'array',
    'comunaIds' => 'array',
    'targetAudience' => 'required|string',
    'scheduled_time' => 'nullable|date',
    'ofertaMunicipal' => 'nullable|string',
    ]);

    // Crea el nuevo registro en la tabla 'gestion_de_notificaciones'
    $gestionDeNotificacion = new Notificacion();
    if ($validatedData['scheduled_time'] == NULL) {
        $status="enviada";
    } else {
        $status="programada";
    }
    
    $gestionDeNotificacion->tipo_notificacion = $validatedData['tipoNotificacion'];
    $gestionDeNotificacion->target_audience = $validatedData['targetAudience'];
    $gestionDeNotificacion->scheduled_time = $validatedData['scheduled_time'];
    $gestionDeNotificacion->region_ids = json_encode($validatedData['regionIds']);
    $gestionDeNotificacion->comuna_ids = json_encode($validatedData['comunaIds']);
    $gestionDeNotificacion->status = $status; // Estado por defecto
    $gestionDeNotificacion->save();
     // Obtén el ID de la notificación recién creada
     $notificacionId = $gestionDeNotificacion->id;

     // Inserta datos en la tabla 'notificacion_noticias'
     foreach ($validatedData['noticias'] as $noticia) {
         foreach ($validatedData['comunaIds'] as $comunaId) {
             $notificacionNoticia = new NotificacionNoticia();
             $notificacionNoticia->notificacion_id = $notificacionId;
             $notificacionNoticia->noticia_id = $noticia['idnoticia'];
             $notificacionNoticia->comuna_id = $comunaId;
             $notificacionNoticia->save();
         }
     }

    return response()->json(['message' => 'Notificación registrada con éxito'], 201);
   
}

    // Mostrar una notificación específica
    public function show($id)
    {
        $notificacion = Notificacion::with(['region', 'comuna', 'noticia', 'beneficio'])->findOrFail($id);
        return response()->json($notificacion);
    }

    // Actualizar una notificación
    public function update(Request $request, $id)
    {
        $notificacion = Notificacion::findOrFail($id);

        $data = $request->validate([
            'tipo_notificacion' => 'required|in:noticia,beneficio,OfertaMunicipal',
            'contenido_id' => 'nullable|integer',
            'target_audience' => 'required|in:todos,registrados,no_registrados',
            'scheduled_time' => 'nullable|date',
            'nombre' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'archivo' => 'nullable|file|mimes:pdf,xlsx,docx',
            'url' => 'nullable|url',
            'fecha_creacion' => 'nullable|date',
            'region_id' => 'nullable|exists:regiones,id',
            'comuna_id' => 'nullable|exists:comunas,id',
        ]);

        // Manejo de archivo si se carga uno
        if ($request->hasFile('archivo')) {
            // Eliminar el archivo anterior si existe
            if ($notificacion->archivo) {
                Storage::delete($notificacion->archivo);
            }
            $path = $request->file('archivo')->store('oferta_municipal_archivos');
            $data['archivo'] = $path;
        }

        // Actualizar la notificación
        $notificacion->update($data);

        return response()->json($notificacion);
    }

    // Eliminar una notificación
    public function destroy($id)
    {
        $notificacion = Notificacion::findOrFail($id);

        // Eliminar el archivo si existe
        if ($notificacion->archivo) {
            Storage::delete($notificacion->archivo);
        }

        $notificacion->delete();

        return response()->json(null, 204);
    }

    // Enviar notificaciones programadas (este método puede ser parte de un comando o una tarea programada)
    public function sendScheduledNotifications()
    {
        $now = Carbon::now();

        // Obtener notificaciones programadas para el envío
        $notificaciones = Notificacion::where('status', 'programada')
            ->where('scheduled_time', '<=', $now)
            ->get();

        foreach ($notificaciones as $notificacion) {
            // Lógica para enviar la notificación (por ejemplo, usando un servicio de push notifications)
            // Aquí deberías integrar la lógica con Firebase Cloud Messaging o el servicio que utilices
            // ...

            // Marcar la notificación como enviada
            $notificacion->update(['status' => 'enviada']);
        }

        return response()->json(['message' => 'Notificaciones enviadas correctamente.']);
    }
}