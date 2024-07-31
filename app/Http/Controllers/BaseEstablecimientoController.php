<?php
namespace App\Http\Controllers;

use App\Models\BaseEstablecimiento;
use Illuminate\Http\Request;

class BaseEstablecimientoController extends Controller
{
    public function index()
    {
        $baseEstablecimientos = BaseEstablecimiento::all();
        return response()->json($baseEstablecimientos);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'codigo_antiguo' => 'nullable|string|max:255',
            'codigo_vigente' => 'nullable|string|max:255',
            'codigo_madre_antiguo' => 'nullable|string|max:255',
            'codigo_madre_nuevo' => 'nullable|string|max:255',
            'codigo_region' => 'nullable|string|max:255',
        ]);

        $baseEstablecimiento = BaseEstablecimiento::create([
            'codigo_antiguo' => $validatedData['codigo_antiguo'],
            'codigo_vigente' => $validatedData['codigo_vigente'],
            'codigo_madre_antiguo' => $validatedData['codigo_madre_antiguo'],
            'codigo_madre_nuevo' => $validatedData['codigo_madre_nuevo'],
            'codigo_region' => $validatedData['codigo_region'],
        ]);

        return response()->json($baseEstablecimiento, 201);
    }

    public function show($id)
    {
        $baseEstablecimiento = BaseEstablecimiento::findOrFail($id);
        return response()->json($baseEstablecimiento);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'codigo_antiguo' => 'nullable|string|max:255',
            'codigo_vigente' => 'nullable|string|max:255',
            'codigo_madre_antiguo' => 'nullable|string|max:255',
            'codigo_madre_nuevo' => 'nullable|string|max:255',
            'codigo_region' => 'nullable|string|max:255',
        ]);

        $baseEstablecimiento = BaseEstablecimiento::findOrFail($id);
        $baseEstablecimiento->update([
            'codigo_antiguo' => $validatedData['codigo_antiguo'],
            'codigo_vigente' => $validatedData['codigo_vigente'],
            'codigo_madre_antiguo' => $validatedData['codigo_madre_antiguo'],
            'codigo_madre_nuevo' => $validatedData['codigo_madre_nuevo'],
            'codigo_region' => $validatedData['codigo_region'],
        ]);

        return response()->json($baseEstablecimiento);
    }

    public function destroy($id)
    {
        $baseEstablecimiento = BaseEstablecimiento::findOrFail($id);
        $baseEstablecimiento->delete();
        return response()->json(null, 204);
    }
}