<?php

namespace App\Http\Controllers;

use App\Models\UsuarioP;
use App\Models\TipoDeRegistro;
use App\Models\UsuarioFamiliar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class UsuarioPAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        Log::info('Datos recibidos:', $request->except('password'));

        $user = UsuarioP::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            Log::info('Intento de inicio de sesión fallido para el email: ' . $request->email);
            return response()->json(['message' => 'Las credenciales proporcionadas son incorrectas.'], 422);
        }

        $token = $user->createToken('MyAppToken')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuariop,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8', // Asegúrate de validar la confirmación de contraseña
            'fecha_nacimiento' => 'required|date',
            'selectedRegionId' => 'required|integer',
            'selectedComunaId' => 'required|integer',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        try {
            $usuario = new UsuarioP();
            $usuario->nombres = $request->nombres;
            $usuario->apellidos = $request->apellidos;
            $usuario->email = $request->email;
            $usuario->password = Hash::make($request->password);
            $usuario->fecha_nacimiento = $request->fecha_nacimiento;
            $usuario->region_id = $request->selectedRegionId;
            $usuario->comuna_id = $request->selectedComunaId;
            $usuario->save();
    
            return response()->json(['message' => 'Usuario registrado correctamente'], 201);
        } catch (\Exception $e) {
            Log::error('Error al registrar usuario: ' . $e->getMessage());
            return response()->json(['error' => 'Error al registrar usuario'], 500);
        }
    }

    public function checkGestanteUsed($userId)
{
    $hasGestante = UsuarioFamiliar::where('usuarioP_id', $userId)
                                  ->where('tipoderegistro_id', 1) // Assuming 1 is the ID for 'gestante'
                                  ->exists();
    return response()->json($hasGestante);
}

    public function getCurrentUser(Request $request)
    {
        try {
            $user = Auth::user(); // Utiliza Auth::user() para obtener el usuario autenticado
            if ($user) {
                return response()->json($user, 200);
            } else {
                return response()->json(['error' => 'No user authenticated'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener datos del usuario'], 500);
        }
    }
}
