<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Cliente;
use App\models\Tasa_interes;
use DB;
use Datatables;
use Notify;
use App\models\Prestamo;
use App\procedimientos\sp_prestamos;
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
      $btn_editar = '<a href="#" class="bt btn-primary btn-xs botones" id="editar" onclick="prestamos.crear('.$clientes->id.');"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
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

if ($request->input('tipo_prestamo') == 2) {

  $prestamo = Prestamo::create([
      'valor_prestamo' => $request->input('valor'),
      'fecha_prestamo' => $request->input('fecha_prestamo'),
      'plazo' => $request->input('palzo'),
      'fecha_fin',
      'total_intereses',
      'valor_pagar',
      'estado',
      'clientes_id' => $request->input('cliente_id'),
      'tasa_interes_id' => $request->input('tasa_interes_id'),
      'tipo_prestamo' => $request->input('tipo_prestamo'),
      'valor_interes_mensual' => $request->input('interes_mensual'),
    ]);
  
   return json_encode(["respuesta"=>1]);
}
elseif ($request->input('tipo_prestamo') == 1) {
  
    $prestamo = Prestamo::create([
      'valor_prestamo' => $request->input('valor'),
      'fecha_prestamo' => $request->input('fecha_prestamo'),
      'plazo' => $request->input('palzo'),
      'fecha_fin',
      'total_intereses' => $request->input('total_intereses'),
      'valor_pagar' => $request->input('valor_pagar'),
      'estado',
      'clientes_id' => $request->input('cliente_id'),
      'tasa_interes_id' => $request->input('tasa_interes_id'),
      'tipo_prestamo' => $request->input('tipo_prestamo'),
      'valor_interes_mensual' => $request->input('interes_mensual'),
    ]);

     return json_encode(["respuesta"=>1]);
}
    
  }
}
