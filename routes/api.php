<?php
// api.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioPAuthController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ComunaController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\UsuarioFamiliarController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TipoDeRegistroController;
use App\Http\Controllers\EdadFamiliarController;
use App\Http\Controllers\SemanasEmbarazoController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [UsuarioPAuthController::class, 'login']);
Route::post('/register', [UsuarioPAuthController::class, 'register']);

/* Rutas para encontrar las regiones y las comunas */
Route::get('/regiones', [RegionController::class, 'index']);
Route::get('/regiones/{id}/comunas', [ComunaController::class, 'index']);

/* Ruta para encontrar los tipos de registro */
Route::get('/tipos-de-registro', [TipoDeRegistroController::class, 'index']);

Route::get('/check-gestante-used/{userId}', [UsuarioPAuthController::class, 'checkGestanteUsed']);

/* Rutas para redes sociales */
Route::get('login/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('login/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
Route::get('login/facebook', [SocialAuthController::class, 'redirectToFacebook']);
Route::get('login/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);

/* Rutas para usuario familiar crud */
Route::middleware('auth:sanctum')->group(function () {
    Route::get('familiars', [UsuarioFamiliarController::class, 'index']);
    Route::post('familiars', [UsuarioFamiliarController::class, 'store']);
    Route::put('familiars/{id}', [UsuarioFamiliarController::class, 'update']);
    Route::delete('familiars/{id}', [UsuarioFamiliarController::class, 'destroy']);
    Route::get('semanas_embarazos', [SemanasEmbarazoController::class, 'index']);
    Route::get('edades', [EdadFamiliarController::class, 'index']);
});

/* Rutas para tags */
Route::apiResource('/tags', TagController::class);

/* Rutas para noticias */
Route::get('/noticias', [NoticiaController::class, 'getAllNoticias']);
Route::get('/noticias-paginadas', [NoticiaController::class, 'getNoticiasPaginadas']);
Route::get('/noticias/{id}', [NoticiaController::class, 'getNoticiaById']);
Route::post('/noticias', [NoticiaController::class, 'store']);
Route::put('/noticias/{noticia}', [NoticiaController::class, 'update']);
Route::delete('/noticias/{noticia}', [NoticiaController::class, 'destroy']);

// Ruta para acceder a los usuarios registrados desde la App movil y a su grupo familiar
Route::get('/users-with-families', [UsuarioFamiliarController::class, 'getAllUsersWithFamilies'])
    ->name('api.users_with_families');
