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

    public function getComunasByRegion(Request $request)
    {
        $regionIds = $request->input('regionIds');
        $comunas = Comuna::whereIn('region_id', $regionIds)->get();
        return response()->json($comunas);
    }
}
