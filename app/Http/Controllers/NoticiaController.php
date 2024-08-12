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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $rules = [
            'titulo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_hora' => 'nullable|date_format:Y-m-d H:i:s',
            'status' => 'nullable|string',
            'privilegio' => 'nullable|integer',
            'usuariop_id' => 'nullable|integer|exists:user_admins,id',
            'tags_idtags' => 'nullable|integer|exists:tags,idtags',
            'imagen' => 'nullable|string' // No se valida como 'image' porque no es un archivo directo
        ];
    
        $validatedData = $request->validate($rules);
    
        $noticia = Noticia::findOrFail($id);
    
        // Procesar la imagen base64 si existe
        if (!empty($validatedData['imagen'])) {
            $noticia->imagen = $this->processBase64Image($validatedData['imagen']);
        }
    
        // Actualizar los demás campos
        foreach ($validatedData as $key => $value) {
            if ($key !== 'imagen') {
                $noticia->$key = $value;
            }
        }
    
        $noticia->save();
    
        return response()->json([
            'message' => 'Noticia actualizada exitosamente',
            'data' => $noticia
        ]);
    }
    
    /**
     * Procesa una imagen en base64 y la guarda en el sistema de archivos.
     *
     * @param string $base64Image
     * @return string
     */
    protected function processBase64Image(string $base64Image): string
    {
        // Extraer los datos binarios de la imagen
        $imageParts = explode(";base64,", $base64Image);
        $imageType = Str::after($imageParts[0], 'data:image/');
        $imageBase64 = base64_decode($imageParts[1]);
    
        // Generar un nombre único para la imagen
        $imageName = uniqid() . '.' . $imageType;
    
        // Guardar la imagen en el sistema de archivos
        $path = Storage::disk('public')->put('images/' . $imageName, $imageBase64);
    
        // Devolver la ruta pública de la imagen
        return '/storage/images/' . $imageName;
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
