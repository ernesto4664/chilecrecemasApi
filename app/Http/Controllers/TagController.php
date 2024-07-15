<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

Paginator::useBootstrap();

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::paginate(5); // Cambia el número 10 por el número de registros que quieres mostrar por página
        return view('admin.tags.index', compact('tags'));
    }


    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'prioridad' => 'required',
        ]);
        $tag = new Tag();
        $tag->nombre = $request->nombre;
        $tag->prioridad = $request->prioridad;
        $tag->save();

        return redirect()->route('tags.index')->with('success', 'Tag creado exitosamente');
    }

    public function show($id)
    {
        $tag = Tag::findOrFail($id);
        return view('admin.tags.show', compact('tag'));
    }

    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'prioridad' => 'required|integer|between:1,5',
        ]);

        $tag = Tag::findOrFail($id);
        $tag->nombre = $request->nombre;
        $tag->prioridad = $request->prioridad;
        $tag->save();

        return redirect()->route('tags.index')->with('success', 'Tag actualizado exitosamente');
    }


    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect()->route('tags.index')->with('success', '¡La etiqueta se eliminó correctamente!');
    }
}

