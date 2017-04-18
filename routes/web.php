<?php

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
    return view('welcome');
});

Auth::routes();

// Rutas para la vista usuarios...
Route::resource('usuarios','UsuarioController');
Route::get('usuarios/tabla/usuarios','UsuarioController@tabla_usuarios');
Route::post('usuarios/estado/{id}','UsuarioController@inactivar_usuario');
// Rutas para la vista usuarios...

// Rutas para la vista clientes...
Route::resource('clientes','ClienteController');
Route::get('clientes/tabla/clientes','ClienteController@tabla_clientes');
Route::post('clintes/clientes/actualizar','ClienteController@actualizar_datos');
// Rutas para la vista clientes...

// Rutas para prestamos y asiganción de prestamos...

Route::get('/prestamos',[
  'as'=>'prestamos',
  'uses' =>'prestamosController@index'
]);

Route::get('/prestamos/clientes',[
  'as'=>'prestamos/clientes',
  'uses' =>'prestamosController@get_cliente'
]);

Route::get('/prestamos/tabla/clientes','prestamosController@get_tabla_clientes');

Route::post('/crear/prestamo',[
  'as'=>'crear/prestamo',
  'uses' =>'prestamosController@crear_prestamo'
]);

Route::get('/prestamo/consultar/cliente',[
  'as'=>'consultar/cliente',
  'uses' =>'prestamosController@consultar_cliente'
]);

Route::post('/consultar/prestamo',[
  'as'=>'consultar/prestamo',
  'uses'=>'prestamosController@consultar_prestamos'
]);

Route::get('/prestamos/clientes/{id}',[
  'as'=>'/prestamos/clientes',
  'uses'=>'prestamosController@consultar_prestamo_clientes'
]);

Route::post('actualizar/prestamo',[
  'as'=>'/actualizar/prestamo',
  'uses'=>'prestamosController@actualizar_prestamo'
]);

//Rutas para el módulo de abonos

Route::get('abono/prestamos',[
  'as'=>'/abono/prestamos',
  'uses'=>'abonoController@index'
]);

Route::post('/crear/abono',[
  'as'=>'/crear/abono',
  'uses'=>'abonoController@registrar_abono'
]);


// Fin rutas  prestamos y asiganción de prestamos...
Route::get('/home', 'HomeController@index');
