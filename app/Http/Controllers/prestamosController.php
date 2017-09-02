<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Cliente;
use App\models\Tasa_interes;
use DB;
use Datatables;
use Notify;
use App\models\Prestamo;
use App\models\Abono_prestamo;
use App\models\Prestamo_abonos;
use Carbon\Carbon;

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
      $btn_editar = '<a href="#"  class="bt btn-primary btn-xs botones" id="editar_Prestamo" title="Asignar prestamo" onclick="prestamos.crear('.$clientes->id.');"><i class="fa fa-plus" aria-hidden="true"></i>
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

  // Función para retornar la fecha de la proxima cuota....

  public function calcular_fecha_cuota($fecha) {

    $date_actual = Carbon::now();
    $date_parseo = $date_actual->parse($fecha);
    $date_nuevo_mes = $date_parseo->addMonth();
    $date = $date_nuevo_mes->format('Y-m-d');

    return $date;
  }

  public function crear_prestamo(Request $request) {
    try {
      $prestamo = Prestamo::create([
        'valor_prestamo' => $request->input('valor'),
        'fecha_prestamo' => $request->input('fecha_prestamo'),
        'fecha_fin',
        'estado',
        'clientes_id' => $request->input('cliente_id'),
        'tasa_interes_id' => $request->input('tasa_interes_id'),
        'valor_interes_mensual' => $request->input('interes_mensual'),
        ]);

      if ($prestamo != null) {

        $abn_p = Abono_prestamo::create([
          'abono_interes' => 0 ,
          'fecha' => $request->input('fecha_prestamo'),
          'saldo_prestamo' => $prestamo->valor_prestamo,
          'abono_capital'=> 0,
          'valor_abono' => 0
          ]);
      }

      if ($abn_p!= null) {

        $pr_c = Prestamo_abonos::create([
          "prestamo_id" => $prestamo->id,
          "abono_prestamo_id" => $abn_p->id,
          "nuevo_interes_mensual" => $prestamo->valor_interes_mensual,
          "fecha_cuota" => $this->calcular_fecha_cuota($request->input('fecha_prestamo')),
          "estado_prestamo"
          ]);
      }
      return json_encode(["respuesta"=>1]);
    } catch (Exception $e) {

    }
  }

  public function consultar_cliente(){

    $clientes = Cliente::select("clientes.*")
    ->join("prestamo","clientes.id","=","prestamo.clientes_id")
    ->join("prestamo_abonos","prestamo.id","=","prestamo_abonos.prestamo_id")
    ->join("abono_prestamo","prestamo_abonos.abono_prestamo_id","=","abono_prestamo.id")
    ->where('clientes.estado',"=",1)
    ->where('prestamo.estado',1)
    ->where('prestamo_abonos.estado_cuota',"=",1)
    ->get();
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

  public function cartera_cliente($id){

    $cartera_cliente  =  Cliente::select("abono_prestamo.*","prestamo.*")
    ->join("prestamo","clientes.id","=","prestamo.clientes_id")
    ->join("prestamo_abonos","prestamo.id","=","prestamo_abonos.prestamo_id")
    ->join("abono_prestamo","prestamo_abonos.abono_prestamo_id","=","abono_prestamo.id")
    ->where('prestamo.clientes_id',$id)
    ->where('prestamo.estado',1)
    ->get();

    $sum_prestamos  =  Cliente::select("prestamo.valor_prestamo")
    ->join("prestamo","clientes.id","=","prestamo.clientes_id")
    ->where('prestamo.clientes_id',$id)
    ->where('prestamo.estado',1)
    ->get();

    $valor_prestamo = 0;

    foreach ($sum_prestamos as $valor) {
      $valor_prestamo += $valor->valor_prestamo;
    }


    $cartera_intereses = 0;
    $cartera_capital = 0;
    $cartera_deuda_capital = 0;


    foreach ($cartera_cliente as $v) {
      $cartera_intereses += $v->abono_interes;
      $cartera_capital += $v->abono_capital;
    }

    $cartera_deuda_capital = ( $valor_prestamo -  $cartera_capital);

    return json_encode([$cartera_intereses,$cartera_capital,$cartera_deuda_capital]);
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
// Consulto si el cliente ya ha realizado abonos, de ser a si no es posible actualizar el 
// prestamo.

    $consultar_abonos  = Prestamo::select("prestamo_abonos.*","abono_prestamo.*")
    ->join("prestamo_abonos","prestamo.id","=","prestamo_abonos.prestamo_id")
    ->join("abono_prestamo","prestamo_abonos.abono_prestamo_id","=","abono_prestamo.id")
    ->where("prestamo_abonos.prestamo_id","=",$input["id"])
    ->get();

    if ($datos->ajax()) { 

      if (count($consultar_abonos) > 1 ) {

        return json_encode(["mensaje" => 1]);
      }

      else {

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

}
