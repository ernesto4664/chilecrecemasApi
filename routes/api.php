<?php


//use App\Http\Controllers\SSOController;

use App\Http\Controllers\TagController;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioPAuthController;
use App\Http\Controllers\EdadFamiliarController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ComunaController;
use App\Http\Controllers\SemanasEmbarazoController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\UsuarioFamiliarController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\TipoDeRegistroController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [UsuarioPAuthController::class, 'login']);
Route::post('/register', [UsuarioPAuthController::class, 'register']);

/*rutas encontrar las regiones y las comunas*/
Route::get('/regiones', [RegionController::class, 'index']);
Route::get('/regiones/{id}/comunas', [ComunaController::class, 'index']);

/*ruta para encontrar los tipos de registro*/
Route::get('/tipos-de-registro', [TipoDeRegistroController::class, 'index']);

Route::get('/check-gestante-used/{userId}', [UsuarioPAuthController::class, 'checkGestanteUsed']);

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
    Route::get('semanas_embarazos', [SemanasEmbarazoController::class, 'index']);
    Route::get('edades', [EdadFamiliarController::class, 'index']); 
});

Route::apiResource('/tagss', TagController::class);

// la ruta para obtener todas las noticias
Route::get('/noticias', [NoticiaController::class, 'getAllNoticias']);
Route::get('/noticias-paginadas', [NoticiaController::class, 'getNoticiasPaginadas']);
Route::get('/noticias/{id}', [NoticiaController::class, 'getNoticiaById']);

//TODAS LAS PASADAS DE WEB A API

// Rutas para la autenticación SSO
//Route::get('login/sso', [SSOController::class, 'redirectToProvider'])->name('api.sso.login');
//Route::get('login/sso/callback', [SSOController::class, 'handleProviderCallback']);

// Ruta para acceder a los usuarios registrados desde la App movil y a su grupo familiar
Route::get('/users-with-families', [UsuarioFamiliarController::class, 'getAllUsersWithFamilies'])
    ->name('api.users_with_families');

// Rutas para la interfaz web (convertidas a rutas de API)
Route::prefix('admin')->group(function () {
    Route::get('tags', [TagController::class, 'index'])->name('api.tags.index');
    Route::get('tags/create', [TagController::class, 'create'])->name('api.tags.create'); // Esta puede no ser necesaria en una API
    Route::post('tags', [TagController::class, 'store'])->name('api.tags.store');
    Route::get('tags/{idtags}', [TagController::class, 'show'])->name('api.tags.show');
    Route::get('tags/{idtags}/edit', [TagController::class, 'edit'])->name('api.tags.edit'); // Esta puede no ser necesaria en una API
    Route::put('tags/{idtags}', [TagController::class, 'update'])->name('api.tags.update');
    Route::delete('tags/{idtags}', [TagController::class, 'destroy'])->name('api.tags.destroy');

    // Rutas para noticias
    Route::get('noticias', [NoticiaController::class, 'index'])->name('api.noticias.index');
    Route::get('noticias/create', [NoticiaController::class, 'create'])->name('api.noticias.create'); // Esta puede no ser necesaria en una API
    Route::post('noticias', [NoticiaController::class, 'store'])->name('api.noticias.store');
    Route::get('noticias/{noticia}', [NoticiaController::class, 'show'])->name('api.noticias.show');
    Route::get('noticias/{noticia}/edit', [NoticiaController::class, 'edit'])->name('api.noticias.edit'); // Esta puede no ser necesaria en una API
    Route::put('noticias/{noticia}', [NoticiaController::class, 'update'])->name('api.noticias.update');
    Route::delete('noticias/{noticia}', [NoticiaController::class, 'destroy'])->name('api.noticias.destroy');
});
