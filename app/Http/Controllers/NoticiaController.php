<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;

Paginator::useBootstrap();

class NoticiaController extends Controller
{
    public function index()
    {
        $noticias = Noticia::paginate(5);
        return response()->json($noticias);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha_hora' => 'required|date_format:Y-m-d H:i:s',
            'status' => 'required|string',
            'privilegio' => 'required|integer',
            'usuariop_id' => 'required|integer|exists:user_admins,id',
            'tags_idtags' => 'required|integer|exists:tags,idtags',
            'imagen' => 'nullable|image|max:2048'
        ]);
    
        $noticia = new Noticia();
        $noticia->titulo = $validatedData['titulo'];
        $noticia->descripcion = $validatedData['descripcion'];
        $noticia->fecha_hora = $validatedData['fecha_hora'];
        $noticia->status = $validatedData['status'];
        $noticia->privilegio = $validatedData['privilegio'];
        $noticia->usuariop_id = $validatedData['usuariop_id'];
        $noticia->tags_idtags = $validatedData['tags_idtags'];
    
        // Manejar la imagen
        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->store('images', 'public');
            $noticia->imagen = '/storage/' . $imagePath;
        }
    
        $noticia->save();
    
        return response()->json(['message' => 'Noticia creada exitosamente.']);
    }

    public function update(Request $request, $id)
    {
        \Log::info('Contenido de la solicitud (raw):', [$request->getContent()]);
        \Log::info('Contenido de la solicitud:', [$request->all()]);

        $rules = [
            'titulo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_hora' => 'nullable|date_format:Y-m-d H:i:s',
            'status' => 'nullable|string',
            'privilegio' => 'nullable|integer',
            'usuariop_id' => 'nullable|integer|exists:user_admins,id',
            'tags_idtags' => 'nullable|integer|exists:tags,idtags',
            'imagen' => 'nullable|image'
        ];

        if ($request->hasFile('imagen')) {
            $rules['imagen'] = 'image|mimes:jpeg,png,jpg,gif';
        }

        $validatedData = $request->validate($rules);

        $noticia = Noticia::findOrFail($id);

        \Log::info('Datos recibidos para actualización:', $validatedData);
        \Log::info('Datos actuales de la noticia antes de actualizar:', $noticia->toArray());

        foreach ($validatedData as $key => $value) {
            if ($key !== 'imagen') {
                $noticia->$key = $value;
            }
        }

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('public/images');
            $noticia->imagen = $path;
        }

        \Log::info('Datos de la noticia después de asignar los valores pero antes de guardar:', $noticia->toArray());

        $noticia->save();

        \Log::info('Noticia guardada:', $noticia->toArray());

        return response()->json([
            'message' => 'Noticia actualizada exitosamente',
            'data' => $noticia
        ]);
    }
    
    
    public function show($id)
    {
        $noticia = Noticia::with('tags')->find($id);
    
        if (!$noticia) {
            return response()->json(['message' => 'Noticia no encontrada'], 404);
        }
    
        // Aquí te aseguras de incluir los tags en el objeto noticia
        $noticia->tags_idtags = $noticia->tags->pluck('idtags')->toArray();
    
        return response()->json(['data' => $noticia], 200);
    }

    public function destroy($id)
    {
        Noticia::destroy($id);
        return response()->json(null, 204);
    }

    public function getAllNoticias()
    {
        $noticias = Noticia::all();
        return response()->json($noticias);
    }

    public function getNoticiaById($id)
    {
        $noticia = Noticia::findOrFail($id);
        return response()->json($noticia);
    }

    public function getNoticiasPaginadas(Request $request)
    {
        $limit = $request->input('limit', 10);
        $noticias = Noticia::paginate($limit);
        return response()->json($noticias);
    }
}
