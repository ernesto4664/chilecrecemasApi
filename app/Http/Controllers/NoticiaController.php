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
            'fecha_hora' => 'required|date',
            'status' => 'required|string',
            'privilegio' => 'required|integer',
            'usuariop_id' => 'required|integer',
            'tags_idtags' => 'nullable|string', // Asegúrate de que sea una cadena
            'imagen' => 'nullable|image|max:2048'
        ]);
    
        // Manejar tags_idtags
        $tags = isset($validatedData['tags_idtags']) ? json_decode($validatedData['tags_idtags'], true) : null;
    
        if ($tags === null || !is_array($tags) || count($tags) === 0) {
            // Si tags no es válido, asigna un valor predeterminado que existe en la tabla 'tags'.
            // Puedes ajustar esto según tus necesidades. Aquí, asumimos que '1' es un ID válido.
            $tags = 1; // O asigna el ID que sea válido en tu tabla 'tags'
        } else {
            // Si tags es un array, toma el primer valor (puedes ajustar esto según tus necesidades)
            $tags = $tags[0];
        }
    
        $noticia = new Noticia();
        $noticia->titulo = $validatedData['titulo'];
        $noticia->descripcion = $validatedData['descripcion'];
        $noticia->fecha_hora = $validatedData['fecha_hora'];
        $noticia->status = $validatedData['status'];
        $noticia->privilegio = $validatedData['privilegio'];
        $noticia->usuariop_id = $validatedData['usuariop_id'];
    
        // Manejar la imagen
        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->store('images', 'public');
            $noticia->imagen = '/storage/' . $imagePath;
        }
    
        $noticia->tags_idtags = $tags;
    
        $noticia->save();
    
        return response()->json(['message' => 'Noticia creada exitosamente.']);
    }
    
    public function update(Request $request, Noticia $noticia)
    {
        $rules = [
            'titulo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_hora' => 'nullable|date',
            'status' => 'nullable|string',
            'privilegio' => 'nullable|integer',
            'usuariop_id' => 'nullable|integer',
            'tags_idtags' => 'nullable|string'
        ];
    
        if ($request->hasFile('imagen')) {
            $rules['imagen'] = 'image|mimes:jpeg,png,jpg,gif|max:2048';
        }
    
        $validatedData = $request->validate($rules);
    
        \Log::info('Datos recibidos para actualización:', $validatedData);
        \Log::info('Datos actuales de la noticia antes de actualizar:', $noticia->toArray());
    
        // Asignar valores solo si están presentes en los datos validados
        foreach ($validatedData as $key => $value) {
            if ($key !== 'imagen') {
                $noticia->$key = $value;
            }
        }
    
        if (isset($validatedData['tags_idtags'])) {
            $tags = json_decode($validatedData['tags_idtags'], true);
            $noticia->tags_idtags = !empty($tags) ? $tags : 0;
        }
    
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('public/images');
            $noticia->imagen = $path;
        }
    
        \Log::info('Datos de la noticia después de asignar los valores pero antes de guardar:', $noticia->toArray());
    
        $noticia->save();
    
        \Log::info('Noticia guardada:', $noticia->toArray());
    
        return response()->json(['message' => 'Noticia actualizada exitosamente']);
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

    /*extraer todas las noticas para APP */
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
