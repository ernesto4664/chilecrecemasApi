<?php

namespace App\Http\Controllers;

use App\Models\TipoDeRegistro;
use Illuminate\Http\Request;

class TipoDeRegistroController extends Controller
{
    public function index()
    {
        try {
            $tipos = TipoDeRegistro::all();
            return response()->json($tipos);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener los tipos de registro'], 500);
        }
    }
}
