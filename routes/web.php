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


Route::resource('/admin/tags', TagController::class);
Route::resource('/admin/noticias', NoticiaController::class);
