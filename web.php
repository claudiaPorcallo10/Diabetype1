<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('layouts/vistaPrincipal');
});

//Rutas para login
Route::get('/login', ['as'=>'SweetAlert','uses'=>'App\Http\Controllers\usuariosController@inicio']);

Route::post('/login', 'App\Http\Controllers\usuariosController@acceso');

//Rutas para registro
Route::get('/register','App\Http\Controllers\usuariosController@registro');

Route::post('/register','App\Http\Controllers\usuariosController@crearUsuario');

//Rutas para pagina principal y contenido
//Route::get('/inicio', 'App\Http\Controllers\usuariosController@acceso')