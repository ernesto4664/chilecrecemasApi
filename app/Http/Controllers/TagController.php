<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Log;

Paginator::useBootstrap();

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::paginate(10); // Ajusta el número según la cantidad de resultados que quieras por página
        return view('admin.tags.index', compact('tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'prioridad' => 'required|integer',
        ]);

        $tag = new Tag();
        $tag->nombre = $request->nombre;
        $tag->prioridad = $request->prioridad;
        $tag->save();

        return redirect()->route('tags.index')->with('success', 'Tag creado exitosamente.');
        
    }

    public function create()
    {
        return view('admin.tags.create');
    }


    public function show($idtags)
    {
        $tag = Tag::findOrFail($idtags);
        return view('admin.tags.show', compact('tag'));
    }

    public function edit($idtags)
    {
        $tag = Tag::findOrFail($idtags);
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, $idtags)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'prioridad' => 'required|integer|between:1,5',
        ]);

        $tag = Tag::findOrFail($idtags);
        $tag->nombre = $request->nombre;
        $tag->prioridad = $request->prioridad;
        $tag->save();

        return redirect()->route('tags.index')->with('success', 'Tag actualizado exitosamente');
    }

    public function destroy($idtags)
    {
        $tag = Tag::findOrFail($idtags);
        $tag->delete();

        return redirect()->route('tags.index')->with('success', '¡La etiqueta se eliminó correctamente!');
    }
}
