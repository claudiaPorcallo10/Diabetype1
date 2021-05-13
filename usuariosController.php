<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class usuariosController extends Controller
{
/**
 * Determina el acceso a un usuario a la aplicación mediante sus datos
 * 
 * @param \Illuminate\Http\Request $Request
 * @return \Illuminate\Response
 * 
 */

 public function inicio(){
     return view('login');
 }

 //Resquest trae todos los valores que hay dentro de un form 
 public function acceso(Request $Request)
 {
        $Request->validate([
            'usuario' => 'required',
            'password' => 'required'
    ]);

    // //Mandar a llamar variables dentro del request
    $usuario = $Request->input('usuario');
    $password = $Request->input('password');
    
    //el codigo que se quiere mandar a frontend y que se pinte es mediante una variable ej:$resultado
    //Guardar resultado de consulta a la tabla usuario mediante los datos de la vista
    //:: para eloquent significa que despues de que se llama una funcion o a una clase se van a poder usar funciones integradas en eloquent
    $resultado = Usuarios::select('*')
                         ->where('usuario', '=', $usuario)
                         ->where('password', '=', $password)
                         ->first();

    $validacion = ($resultado != null ? true : false);
    $mensaje = ($validacion == false ? Alert::error('Error','Usuario y/o contraseña no válidos') : '');
    


    return view('login')
            ->with('mensaje', $mensaje);

 }

 public function registro(){
        return view('register');
 }

public function crearUsuario(Request $Request){

    $Request->validate([
        'nombre' => 'required|regex:/^[a-zA-Z -]+$/',
        'apellido' => 'required|regex:/^[a-zA-Z -]+$/',
        'usuario' => 'required|min:8|max:15',
        'password' => 'required',
        'email' => 'required'
    ]);

    $nombre = $Request->input('nombre');
    $apellido = $Request->input('apellido');
    $usuario = $Request->input('usuario');
    $password = $Request->input('password');
    $email = $Request->input('email');

    //Consulta que exista en la base de datos 
    //Todas las columnas de un registro = Usuarios::select('*')
    $resultado = Usuarios::select('*')
        ->where('nombre', '=', $nombre)
        ->where('apellidos', '=', $apellido)
        ->where('usuario', '=', $usuario)
        ->where('password', '=', $password)
        ->where('email', '=', $email)
        ->first();

        //condicion para 
    if($resultado != null){
        return view('register')
                ->with('mensaje', Alert::error('Error', 'El usuario ya se encuentra registrado'));
    }

    //Insertar el resultado para almacenar en la base de datos
    $id = Usuarios::insertGetId(
        ['nombre' => $nombre,
        'apellidos' => $apellido,
        'usuario' => $usuario,
        'password' => $password,
        'email' => $email,
        'created_at' => Carbon::now()]
    );

    $mensaje = ($id == 0 ? Alert::error('Error','Usuario y/o contraseña no válidos') : Alert::success('Exito', 'Usuario registrado correctamente'));

    if($id =! 0){
    return view('login')
            ->with('mensaje', $mensaje);
    }
    else{
        return view('register')
        ->with('mensaje', $mensaje);
    }
}
}