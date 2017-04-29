<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Cliente;
use App\models\Tasa_interes;
use DB;
use Datatables;
use Notify;
use App\models\Prestamo;

class prestamosController extends Controller
{
  public function index(){
    $interes = Tasa_interes::pluck('interes','id');
    return View('asignar_prestamo',compact('interes'));
  }

  public function get_tabla_clientes (){

    $clientes = Cliente::select('clientes.*')
    ->where('estado', 1)
    ->get();

    return Datatables::of($clientes)

    ->addColumn('action', function ($clientes) {
      $btn_editar = "";
      $btn_editar = '<a href="#" class="bt btn-primary btn-xs botones" id="editar" title="Asignar prestamo" onclick="prestamos.crear('.$clientes->id.');"><i class="fa fa-plus" aria-hidden="true"></i>
    </a>';

    return $btn_editar;

  })
    ->editColumn('estado', function ($clientes) {
      return $clientes->estado == 1 ? "Activo" : "Inactivo";
    })
    ->make(true);
  }


  public function get_cliente(Request $request){

    if($request->ajax()){
      $cliente = CLiente::find($request->input('id'));
      if ($cliente != null) {
        return json_encode($cliente);

      }else {
        return false;
      }
    }else {
      return false;
    }
  }

  public function crear_prestamo(Request $request) {

    $prestamo = Prestamo::create([
      'valor_prestamo' => $request->input('valor'),
      'fecha_prestamo' => $request->input('fecha_prestamo'),
      'fecha_fin',
      'estado',
      'clientes_id' => $request->input('cliente_id'),
      'tasa_interes_id' => $request->input('tasa_interes_id'),
      'valor_interes_mensual' => $request->input('interes_mensual'),
      ]);

    return json_encode(["respuesta"=>1]);
  }

  

  public function consultar_cliente(){

    $clientes =  Cliente::all();
    $interes = Tasa_interes::pluck('interes','id');
    return view("consultar_prestamo",compact("clientes","interes"));
  }

  public function consultar_prestamos(Request $request){

    $id = $request->input("id");


    $prestamo = Cliente::select("clientes.documento","clientes.nombre","clientes.primer_apellido","prestamo.*","prestamo.id as id_prestamo","tasa_interes.*")
    ->join("prestamo","clientes.id","=","prestamo.clientes_id")
    ->join("tasa_interes","tasa_interes.id","=","prestamo.tasa_interes_id")
    ->where('prestamo.clientes_id',$id)
    ->where('prestamo.estado',1)
    ->get();

    return json_encode([$prestamo]);
  }

  public function consultar_prestamo_clientes($id){

    $datos =  $prestamo = Cliente::select("clientes.documento","clientes.nombre","clientes.primer_apellido","prestamo.*","prestamo.id as id_prestamo","tasa_interes.*")
    ->join("prestamo","clientes.id","=","prestamo.clientes_id")
    ->join("tasa_interes","tasa_interes.id","=","prestamo.tasa_interes_id")
    ->where('prestamo.id',$id)
    ->get();

    return json_encode($datos);
  }

  public function actualizar_prestamo(Request $datos){

    $input = $datos->all();

    if ($datos->ajax()) {
      try{

        $up_prestamo = Prestamo::find($input["id"]);

        if($up_prestamo != null){

          $res =  DB::table('prestamo')
          ->where('id','=',$up_prestamo->id)
          ->update([
            'valor_prestamo' => $input['valor_prestamo'],
            'fecha_prestamo' => $input['fecha_prestamo'],
            'fecha_fin'=>null,
            'estado' => $input['estado'],
            'clientes_id'=>$up_prestamo->clientes_id,
            'tasa_interes_id' => $input['tasa_interes'],
            'valor_interes_mensual' => $input['valor_interes_mensual'],
            ]);
        }
        if ($res != null) {

         return json_encode(["mensaje" => 2]);
       }

     }
     catch(exception $e) {
      return json_encode(["mensaje" => 3]);
    }

  }
}

}

