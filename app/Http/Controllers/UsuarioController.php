<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Usuarios;
use App\models\Rol;
use Datatables;
use DB;
use Pnotify;

class UsuarioController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */

  public function index()
  {
    $roles = Rol::pluck('nombre','id');
    return view('usuarios',compact('roles'));

  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    //
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */

  /*Método para crear usuarios implementando ajax*/
  public function store(Request $request)
  {
    $usuarios = new Usuarios();
    if ($request->ajax()) {
      $usuarios->nombre = $request->input('nombre');
      $usuarios->email = $request->input('email');
      $usuarios->password = $request->input('password');
      $usuarios->rol_id = $request->input('rol');
      $usuarios->save();
      //  Devuelvo una respuesta...
      return response()->json([
        "mensaje"=> 'se guardo'
      ]);
    }
  }

  // Método para mostrar la tabla en la vista...
  public function tabla_usuarios(){

    $result = Usuarios::select('login.*','rol.nombre as rol')
    ->join('rol','rol.id', '=','login.rol_id')
    ->get();

    return Datatables::of($result)

    ->addColumn('action',function($result){

      $btn_editar = "";
      $btn_inactivar = "";
      $btn_eliminar = "";

      $btn_editar = '<a href="#" class="btn btn-primary btn-xs botones" onclick="usuarios.editar_usuario('.$result->id.');" id="editar"><i class="fa fa-pencil-square-o iconos-botones" aria-hidden="true"> </i> Editar</a>';
      $btn_eliminar = '<a href="#" class="btn btn-danger btn-xs botones" onclick="usuarios.eliminar('.$result->id.');"  id="eliminar"><i class="fa fa-trash-o iconos-botones" aria-hidden="true"></i> Eliminar</a>';

      if($result->estado == 0){
        $activo = 1;
        $btn_inactivar = '<a href="#" class="bt btn-success btn-xs botones" id="editar" onclick="usuarios.cambiar_estado('.$result->id.','.$activo.');"><i class="fa fa-check" aria-hidden="true"></i>
        Activar</a>';
      }else {
        if ($result->estado == 1) {
          $inactivo = 0;
          $btn_inactivar = '<a href="#" class="bt btn-danger btn-xs botones" id="editar" onclick="usuarios.cambiar_estado('.$result->id.','.$inactivo.');"><i class="fa fa-remove" aria-hidden="true"></i>
          Inactivar</a>';
        }
      }

      return $btn_editar.$btn_inactivar.$btn_eliminar;
      // Con esta funcion puedo cambiar el nombre de un campo en la tabla...
    })->editColumn('estado', function ($result) {
      return $result->estado == 0 ? "Inactivo" : "Activo";
    })
    ->make(true);
  }



  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  // Método para buscar el usuario y loego retornarlo a la vista para actualizar...
  public function edit($id)
  {
    $usuarios = Usuarios::find($id);

    if($usuarios == null){
      // utilar nitify para los mensajes...
      return redirect('usuarios');
    }else {
      return json_encode($usuarios);
    }

  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  //  Método para actualizar usuarios recibe un json...
  public function update(Request $request, $id)
  {

    $usuarios = Usuarios::find($id);
    if ($usuarios != null) {
      $datos=[
        'nombre' => $request->input('nombre'),
        'email' => $request->input('email'),
        'password' => $request->input('password'),
        'rol_id' => $request->input('rol'),
        'estado' => $request->input('estado')
      ];
      return json_encode(["mensaje"=>1]);
    }else {
      return json_encode(["mensaje"=>2]);
    }

  }

  // Método para cambiar estado....
  public function inactivar_usuario (Request $request, $id){
    $usuarios =  Usuarios::find($id);

    $usuarios = Usuarios::find($id);
    if ($usuarios != null) {
      $usuarios->update(['estado'=>$request->input('estado')]);
      return json_encode(["mensaje"=>1]);
    }else {
      return json_encode(["mensaje"=>2]);
    }

    /*Para realizar un update con Eloquent los datos de los campo a actualizar se envian en forma de array..*/
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    $usuarios =  Usuarios::find($id);
    $usuarios->delete();
    return json_encode(['mensaje' => 1]);
  }
}
