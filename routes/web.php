<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SSOController;
use App\Http\Controllers\UsuarioFamiliarController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\NoticiaController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Rutas para la autenticación SSO
Route::get('login/sso', [SSOController::class, 'redirectToProvider'])->name('sso.login');
Route::get('login/sso/callback', [SSOController::class, 'handleProviderCallback']);
/*
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});
*/
//Route::post('/login', [UserAuthController::class, 'login']);

// Otras rutas de tu aplicación
Route::get('/', function () {
    return view('welcome');
});


// Ruta para acceder a los usuarios registrados desde la App movil y a su grupo familiar
Route::get('/admin/users-with-families', [UsuarioFamiliarController::class, 'getAllUsersWithFamilies'])
    ->name('admin.users_with_families');

// Rutas para la interfaz web
Route::prefix('admin')->group(function () {
    Route::get('tags', [TagController::class, 'index'])->name('tags.index');
    Route::get('tags/create', [TagController::class, 'create'])->name('tags.create');
    Route::post('tags', [TagController::class, 'store'])->name('tags.store');
    Route::get('tags/{idtags}', [TagController::class, 'show'])->name('tags.show');
    Route::get('tags/{idtags}/edit', [TagController::class, 'edit'])->name('tags.edit');
    Route::put('tags/{idtags}', [TagController::class, 'update'])->name('tags.update');
    Route::delete('tags/{idtags}', [TagController::class, 'destroy'])->name('tags.destroy');

        // Rutas para noticias
    Route::get('noticias', [NoticiaController::class, 'index'])->name('noticias.index');
    Route::get('noticias/create', [NoticiaController::class, 'create'])->name('noticias.create');
    Route::post('noticias', [NoticiaController::class, 'store'])->name('noticias.store');
    Route::get('noticias/{noticia}', [NoticiaController::class, 'show'])->name('noticias.show');
    Route::get('noticias/{noticia}/edit', [NoticiaController::class, 'edit'])->name('noticias.edit');
    Route::put('noticias/{noticia}', [NoticiaController::class, 'update'])->name('noticias.update');
    Route::delete('noticias/{noticia}', [NoticiaController::class, 'destroy'])->name('noticias.destroy');
});