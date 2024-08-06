<?php
// api.php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
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
use App\Http\Controllers\EtapaController;
use App\Http\Controllers\SSOController;
use App\Http\Controllers\BeneficioController;
use App\Http\Controllers\BaseEstablecimientoController;
use App\Http\Controllers\UbicacionController;

// Rutas para la autenticación SSO
Route::get('login/sso', [SSOController::class, 'redirectToProvider'])->name('sso.login');
Route::get('login/sso/callback', [SSOController::class, 'handleProviderCallback']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/user', [UsuarioPAuthController::class, 'getCurrentUser']);

Route::post('/login', [UsuarioPAuthController::class, 'login']);
Route::post('/register', [UsuarioPAuthController::class, 'register']);

/* Rutas para encontrar las regiones y las comunas */
Route::get('/regiones', [RegionController::class, 'index']);
Route::post('/comunas-by-region', [RegionController::class, 'getComunasByRegion']);
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
Route::get('tags', [TagController::class, 'index']);
Route::post('tags', [TagController::class, 'store']);
Route::get('tags/{id}', [TagController::class, 'show']);
Route::put('tags/{id}', [TagController::class, 'update']);
Route::delete('tags/{id}', [TagController::class, 'destroy']);

/* Rutas para noticias */
Route::get('/noticias', [NoticiaController::class, 'getAllNoticias']);
Route::get('/noticias-paginadas', [NoticiaController::class, 'getNoticiasPaginadas']);
Route::get('/noticias/{id}', [NoticiaController::class, 'getNoticiaById']);
Route::post('/noticias', [NoticiaController::class, 'store']);
Route::patch('/noticias/{noticia}', [NoticiaController::class, 'update']);
Route::delete('/noticias/{noticia}', [NoticiaController::class, 'destroy']);


Route::put('/noticias/{noticia}', [NoticiaController::class, 'update']);


// Ruta para acceder a los usuarios registrados desde la App movil y a su grupo familiar
Route::get('/users-with-families', [UsuarioFamiliarController::class, 'getAllUsersWithFamilies'])
    ->name('api.users_with_families');

//GESTION DE ETAPAS
Route::get('etapas', [EtapaController::class, 'index']);
Route::post('etapas', [EtapaController::class, 'store']);
Route::get('etapas/{etapa}', [EtapaController::class, 'show']);
Route::put('etapas/{etapa}', [EtapaController::class, 'update']);
Route::delete('etapas/{etapa}', [EtapaController::class, 'destroy']);
Route::get('etapas/tipoUsuario/{tipoUsuario}', [EtapaController::class, 'getEtapasByTipoUsuario']);

//GESTION DE BENEFICIOS, UBICACIONES, BASEESTABLECIMIENTOS

Route::apiResource('beneficios', BeneficioController::class);
Route::get('beneficios/etapas/{tipo_usuario}', [BeneficioController::class, 'getEtapasByTipoUsuario']);
Route::get('/beneficios/etapa/{etapa_id}', [BeneficioController::class, 'getBeneficiosByEtapa']);
Route::get('beneficios/filter', [BeneficioController::class, 'filterByRegionComuna']);

Route::apiResource('base-establecimientos', BaseEstablecimientoController::class);
Route::apiResource('ubicaciones', UbicacionController::class);
Route::post('/ubicaciones', [UbicacionController::class, 'store']);
Route::post('/comunas-by-regions', [UbicacionController::class, 'getComunasByRegions']);
Route::post('/ubicaciones-by-regions-and-comunas', [UbicacionController::class, 'getUbicacionesByRegionsAndComunas']);