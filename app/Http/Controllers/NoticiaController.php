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
    $request->validate([
        'titulo' => 'required|string|max:500',
        'descripcion' => 'required|string',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'fecha_hora' => 'nullable|date',
        'status' => 'nullable|string',
        'privilegio' => 'nullable|string',
        'tags_idtags' => 'nullable|integer',
        'usuariop_id' => 'nullable|integer',
    ]);

    $data = $request->all();

    if ($request->hasFile('imagen')) {
        $imagePath = $request->file('imagen')->store('images', 'public');
        $data['imagen'] = '/storage/' . $imagePath;
    }

    Noticia::create($data);

    return redirect()->route('noticias.index')->with('success', 'Noticia creada exitosamente');
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
        $request->validate([
            'titulo' => 'required|string|max:500',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'fecha_hora' => 'nullable|date',
            'status' => 'nullable|string',
            'privilegio' => 'nullable|string',
            'tags_idtags' => 'nullable|integer',
            'usuariop_id' => 'nullable|integer',
        ]);
    
        $noticia = Noticia::findOrFail($id);
        $data = $request->all();
    
        if ($request->hasFile('imagen')) {
           
            // Guardar la nueva imagen
            $imagePath = $request->file('imagen')->store('images', 'public');
            $data['imagen'] = '/storage/' . $imagePath;
        }
    
        $noticia->update($data);
    
        return redirect()->route('noticias.index')->with('success', 'Noticia actualizada exitosamente');
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
