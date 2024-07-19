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
        return response()->json($tags);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'prioridad' => 'required|integer',
        ]);

        $tag = Tag::create($request->all());

        return response()->json($tag, 201);
    }

    public function show($id)
    {
        $tag = Tag::findOrFail($id);
        return response()->json($tag);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'prioridad' => 'required|integer|between:1,5',
        ]);

        $tag = Tag::findOrFail($id);
        $tag->update($request->all());

        return response()->json($tag);
    }

    public function destroy($id)
    {
        Tag::destroy($id);
        return response()->json(null, 204);
    }
}
