<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

Paginator::useBootstrap();
class NoticiaController extends Controller
{
    public function index()
    {
        $noticias = Noticia::paginate(5);
        return view('admin.noticia.index', compact('noticias'));
    }

    public function create()
    {
        $tags = Tag::all(); // Suponiendo que tienes un modelo Tag para tus tags
        return view('admin.noticia.create', compact('tags'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'nullable|url',
            'fecha_hora' => 'nullable|date',
            'status' => 'nullable|max:45',
            'privilegio' => 'nullable|max:45',
            'tags_idtags' => 'required|exists:tags,idtags',
            'usuariop_id' => 'required|integer',
        ]);
    
        // Lógica para guardar la noticia con los datos validados
        // Ejemplo:
        $noticia = new Noticia();
        $noticia->titulo = $validatedData['titulo'];
        $noticia->descripcion = $validatedData['descripcion'];
        $noticia->imagen = $validatedData['imagen'];
        $noticia->fecha_hora = $validatedData['fecha_hora'];
        $noticia->status = $validatedData['status'];
        $noticia->privilegio = $validatedData['privilegio'];
        $noticia->tags_idtags = $validatedData['tags_idtags'];
        $noticia->usuariop_id = $validatedData['usuariop_id'];
        $noticia->save();
    
        return redirect()->route('noticias.index')->with('success', 'Noticia creada correctamente.');
    }
    

    public function show($id)
    {
        $noticia = Noticia::findOrFail($id);
        $tags = Tag::all(); // Asegúrate de cargar todos los tags o los necesarios para esta vista

        return view('admin.noticia.show', compact('noticia', 'tags'));
    }


    public function edit($id)
    {
        $noticia = Noticia::findOrFail($id);
        $tags = Tag::all(); // O la consulta que necesites para obtener los tags

        return view('admin.noticia.edit', compact('noticia', 'tags'));
    }


    public function update(Request $request, $id)
    {
        // Validación de los datos del formulario
    

        $validatedData = $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'nullable|url',
            'fecha_hora' => 'nullable|date',
            'status' => 'nullable|max:45',
            'privilegio' => 'nullable|max:45',
            'tags_idtags' => 'required|exists:tags,idtags',
            'usuariop_id' => 'required|integer',
        ]);

        // Buscar la noticia por su ID
        $noticia = Noticia::findOrFail($id);
  
        $noticia->titulo = $validatedData['titulo'];
        $noticia->descripcion = $validatedData['descripcion'];
        $noticia->imagen = $validatedData['imagen'];
        $noticia->fecha_hora = $validatedData['fecha_hora'];
        $noticia->status = $validatedData['status'];
        $noticia->privilegio = $validatedData['privilegio'];
        $noticia->tags_idtags = $validatedData['tags_idtags'];
        $noticia->usuariop_id = $validatedData['usuariop_id'];
        $noticia->save();

        // Redirigir a una vista de confirmación, por ejemplo
        return redirect()->route('noticias.show', $noticia->idnoticia);
    }

    

    public function destroy(Noticia $noticia)
    {
        $noticia->delete();
        return redirect()->route('noticias.index')->with('success', 'Noticia eliminada exitosamente.');
    }

    /*extraer todas las noticas para APP */
    public function getAllNoticias()
    {
        $noticias = Noticia::all();
        return response()->json($noticias);
    }
}
