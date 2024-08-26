<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Comuna; // Asegúrate de importar el modelo
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        $regiones = Region::all();
        return response()->json($regiones);
    }

    public function getComunasByRegions(Request $request)
    {
        $regionIds = $request->input('regionIds');
    
        // Asegúrate de que regionIds es un array plano
        if (is_array($regionIds) && !empty($regionIds)) {
            $regionIds = array_map('intval', $regionIds); // Asegúrate de que todos los IDs son enteros
            $comunas = Comuna::whereIn('region_id', $regionIds)->get(); // Asegúrate de que whereIn maneje el array correctamente
            return response()->json($comunas);
        } else {
            return response()->json(['error' => 'Invalid region IDs'], 400);
        }
    }
}
