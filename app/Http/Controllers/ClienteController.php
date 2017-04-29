<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Cliente;
use App\models\Tipo_documento;
use App\models\Tipo_cuenta;
use App\models\Rol;
use App\models\Cuenta;
use Datatables;
use Pnotify;
use DB;

class ClienteController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $document = Tipo_documento::pluck('tipo_documento','id');
    $cuenta = Tipo_cuenta::pluck('tipo_cuenta','id');
    return View('/clientes', compact('document','cuenta'));
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
  public function store(Request $request)
  {
    if($request->ajax()){

      try {
        DB::transaction(function() use($request) {

          $cliente_id = Cliente::create([
            'nombre' => $request->input('nombre'),
            'primer_apellido' => $request->input('primer_apellido'),
            'segundo_apellido'=> $request->input('segundo_apellido'),
            'documento'  => $request->input('documento'),
            'direccion' => $request->input('direccion'),
            'telefono' => $request->input('telefono'),
            'celular'  => $request->input('celular'),
            'email' => $request->input('email'),
            'tipo_documento_id'=> $request->input('tipo_documento'),
          ]);



          $cuenta = new Cuenta();

          $cuenta->numero = $request->input('cuenta');
          $cuenta->tipo_cuenta_id = $request->input('tipo_cuenta');
          $cuenta->clientes_id = $cliente_id->id;

          $cuenta->save();
        });

        return json_encode(["respuesta"=>1]);
      } catch (Exception $e) {
        return json_encode(["respuesta"=>2]);
      }
    }

    else{
      return json_encode(["respuesta"=>3]);
    }
  }

  public function tabla_clientes(){

    $resultado = Cliente::all();
    
    return Datatables::of($resultado)

    ->addColumn('action', function ($resultado) {
      $btn_editar = "";
      $btn_inactivar = "";

      $btn_editar = '<a href="#" class="bt btn-primary btn-xs botones" id="editar" onclick="cliente.editar('.$resultado->id.');"><i class="fa fa-plus" aria-hidden="true"></i>
      </a>';

      if($resultado->estado == 0){
        $activo = 1;
        $btn_inactivar = '<a href="#" class="bt btn-success btn-xs botones" id="editar" onclick="cliente.cambiar_estado('.$resultado->id.','.$activo.');"><i class="fa fa-check" aria-hidden="true"></i>
          Activar</a>';
      }else {
        if ($resultado->estado == 1) {
          $inactivo = 0;
          $btn_inactivar = '<a href="#" class="bt btn-danger btn-xs botones" id="editar" onclick="cliente.cambiar_estado('.$resultado->id.','.$inactivo.');"><i class="fa fa-remove" aria-hidden="true"></i>
          Inactivar</a>';
        }
      }
      return $btn_editar.$btn_inactivar;

    })
    ->editColumn('estado', function ($resultado) {
      return $resultado->estado == 1 ? "Activo" : "Inactivo";
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

  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {

    $cliente = Cliente::select('clientes.*','cuenta.numero as cuenta','cuenta.id as cuenta_id','tipo_cuenta.id as id_tipo_cuenta','tipo_documento')
    ->leftJoin('cuenta','clientes.id','=','clientes_id')
    ->leftJoin('tipo_cuenta','tipo_cuenta.id','=','tipo_cuenta_id')
    ->join('tipo_documento','tipo_documento.id','=','tipo_documento_id')
    ->where('clientes.id', $id)
    ->get();

    return response()->json([
      "cliente"=>$cliente
    ]);
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */

  // En este método actualizo el estado del cliente.....
  public function update(Request $request, $id)
  {
    
      $cliente =  Cliente::find($id);

    if ($cliente != null) {

      $cliente->update(['estado'=>$request->input('estado')]);
       
      return json_encode(["mensaje"=>1]);

    }else {

      return json_encode(["mensaje"=>2]);
    }
  }

  public function actualizar_datos(Request $request){

    if($request->ajax()){

      //Actualizo todo lo que tenga que ver con el cliente...
      $cliente = CLiente::find($request->input('id_cliente_editar'));

      if($cliente != null){
        $datos_cliente = [
          'nombre' => $request->input('nombre_editar'),
          'primer_apellido' => $request->input('primer_apellido_editar'),
          'segundo_apellido' => $request->input('segundo_apellido_editar'),
          'documento' => $request->input('documento_editar'),
          'direccion' => $request->input('direccion_editar'),
          'telefono' => $request->input('telefono_editar'),
          'celular' => $request->input('celular_editar'),
          'email' => $request->input('email_editar'),
          'estado' => $request->input('estado_editar'),
          'tipo_documento_id' => $request->input('tipo_documento_editar')
        ];

        $cliente->update($datos_cliente);
      }else {
        return json_encode(["mensaje"=>3]);
      }

      // Nota: cuando realizo una consulta con where siempre debo de poner al final ->firts() o ->get()......
      $cuenta =  Cuenta::where('clientes_id',$request->input('id_cliente_editar'))->first();

      if( $cuenta !=null ){

        $datos_cuenta = [
          'numero' => $request->input('cuenta_editar'),
          'tipo_cuenta_id' => $request->input('tipo_cuenta_editar'),
        ];
        $cuenta->update($datos_cuenta);

        return json_encode(["mensaje"=>1]);

      }else {
        return json_encode(["mensaje"=>2]);
      }

    }else {
      return json_encode(["mensaje"=>4]);
    }
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    //
  }
}
