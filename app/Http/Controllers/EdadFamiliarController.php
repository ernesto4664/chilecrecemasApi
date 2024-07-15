<?php

namespace App\Http\Controllers;

use App\Models\EdadFamiliar;
use Illuminate\Http\Request;

class EdadFamiliarController extends Controller
{
    public function index()
    {
        try {
            $edades = EdadFamiliar::all();
            return response()->json($edades, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener edades'], 500);
        }
    }
}
