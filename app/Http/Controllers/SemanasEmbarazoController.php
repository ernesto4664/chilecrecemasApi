<?php

namespace App\Http\Controllers;

use App\Models\SemanasEmbarazo;
use Illuminate\Http\Request;

class SemanasEmbarazoController extends Controller
{
    public function index()
    {
        try {
            $semanas = SemanasEmbarazo::all();
            return response()->json($semanas, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener semanas de embarazo'], 500);
        }
    }
}
