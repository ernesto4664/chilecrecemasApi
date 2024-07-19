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
        return response()->json($noticias);
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

        $noticia = Noticia::create($data);

        return response()->json($noticia, 201);
    }

    public function show($id)
    {
        $noticia = Noticia::findOrFail($id);
        return response()->json($noticia);
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
            $imagePath = $request->file('imagen')->store('images', 'public');
            $data['imagen'] = '/storage/' . $imagePath;
        }

        $noticia->update($data);

        return response()->json($noticia);
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
