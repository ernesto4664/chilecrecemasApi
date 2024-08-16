<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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
            $path = $request->file('archivo')->store('oferta_municipal_archivos');
            $data['archivo'] = $path;
        }

        // Crear la notificación
        $notificacion = Notificacion::create($data);

        return response()->json($notificacion, 201);
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