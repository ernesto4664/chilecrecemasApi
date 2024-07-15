<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioPAuthController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ComunaController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\UsuarioFamiliarController;
use App\Http\Controllers\NoticiaController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [UsuarioPAuthController::class, 'login']);
Route::post('/register', [UsuarioPAuthController::class, 'register']);

Route::get('/regiones', [RegionController::class, 'index']);
Route::get('/regiones/{id}/comunas', [ComunaController::class, 'index']);

/*rutas para redes sociales*/
Route::get('login/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('login/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
Route::get('login/facebook', [SocialAuthController::class, 'redirectToFacebook']);
Route::get('login/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);

/*rutas para usuario familiar crud*/
Route::middleware('auth:sanctum')->group(function () {
    Route::get('familiars', [UsuarioFamiliarController::class, 'index']);
    Route::post('familiars', [UsuarioFamiliarController::class, 'store']);
    Route::put('familiars/{id}', [UsuarioFamiliarController::class, 'update']);
    Route::delete('familiars/{id}', [UsuarioFamiliarController::class, 'destroy']);
});

// la ruta para obtener todas las noticias
Route::get('/noticias', [NoticiaController::class, 'getAllNoticias']);
