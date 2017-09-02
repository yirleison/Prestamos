<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redis;
use App\models\Cliente;
use App\models\Tasa_interes;
use DB;
use App\models\Prestamo;
use App\models\Prestamo_abonos;
use App\models\Abono_prestamo;

class NotificacionesController extends Controller
{
	public function moraCLientes(Request $id) {

		$con_abn  = Cliente::select("clientes.id as idcliente","prestamo_abonos.fecha_cuota","clientes.nombre","clientes.primer_apellido","prestamo_abonos.id as id_cuota","prestamo.id as id_prestamo","prestamo_abonos.nuevo_interes_mensual","prestamo_abonos.fecha_cuota")
						  		->join ("prestamo", "clientes.id", "=", "prestamo.clientes_id")
						  		->join("prestamo_abonos","prestamo.id","=","prestamo_abonos.prestamo_id")
						  		->join("abono_prestamo","prestamo_abonos.abono_prestamo_id","=","abono_prestamo.id")
						  		->where("clientes.id","=",$id->input("id"))
						  		->where('clientes.estado','1')
							  	->where('prestamo.estado', '1')
							  	->where('prestamo_abonos.estado_cuota', '1')
						  		->get();

		return json_encode(["datos"=>$con_abn]);

	}

	public function consultarCuotas(Request $id_cliente) {

		$cuotas = DB::table("prestamo")
						->join("prestamo_abonos","prestamo.id","=","prestamo_abonos.prestamo_id")
						->where ("prestamo.estado", "=", 1)
						->where ("prestamo_abonos.estado_cuota", "=", 1)
						->where ("prestamo.clientes_id", "=", $id_cliente->input("id_cliente"))
						->get();

		return json_encode($cuotas);

	}
}
