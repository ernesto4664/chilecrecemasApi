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
        $tags = Tag::paginate(10);
        return response()->json([
            'message' => 'Tags retrieved successfully',
            'data' => $tags
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'prioridad' => 'required|integer',
        ]);

        $tag = Tag::create($request->all());

        return response()->json([
            'message' => 'Tag created successfully',
            'data' => $tag
        ], 201);
    }

    public function show($id)
    {
        $tag = Tag::findOrFail($id);
        return response()->json([
            'message' => 'Tag retrieved successfully',
            'data' => $tag
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'prioridad' => 'required|integer',
        ]);

        $tag = Tag::findOrFail($id);

        \Log::info('Datos actuales del tag antes de actualizar:', $tag->toArray());

        $tag->nombre = $request->input('nombre');
        $tag->prioridad = $request->input('prioridad');

        \Log::info('Datos del tag después de asignar los valores pero antes de guardar:', $tag->toArray());

        $tag->save();

        \Log::info('Tag guardado:', $tag->toArray());

        return response()->json([
            'message' => 'Tag updated successfully',
            'data' => $tag
        ]);
    }

    public function destroy($id)
    {
        Tag::destroy($id);
        return response()->json([
            'message' => 'Tag deleted successfully'
        ], 204);
    }
}
