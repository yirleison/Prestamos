<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Notify;
use App\models\Abono_prestamo;
use App\models\Cliente;
use App\models\Tasa_interes;
use App\models\Prestamo;
use App\models\Prestamo_abonos;
use Carbon\Carbon;


class abonoController extends Controller
{
	
	
	public function index() {
		
	  $clientes = Cliente::select("clientes.*")
    ->join("prestamo","clientes.id","=","prestamo.clientes_id")
    ->where('clientes.estado',"=",1)
    ->where('prestamo.estado',"=",1)
    ->get();
    
		return view("crear_abono", compact("clientes"));
	}
	
	// 	Metodo para crear los abonos a los respectivos prestamos
	
	public function registrar_abono(Request $datos){
		
		$date_actual = Carbon::now();
		$date_parseo = $date_actual->parse($datos->input("fecha"));
		//v		ar_dump($date);
		$date_nuevo_mes = $date_parseo->addMonth();
		
		$date = $date_nuevo_mes->format('Y-m-d');
		
		$f_a =  Carbon::now()->format('Y-m-d');
		$input = $datos->all();
		$id_prestamo = $input["id_prestamo"];
		
		//C		alculo proxima fecha de pago...
										//$		dia = date("d",(mktime(0,0,0,$mes+1,1,$anio)-1));
		
		//$		date = $anio."-".$mes."-".$dia;
		
		$sal = $input["valor_abono"];
		
		$interes_actual = 0;
		$pr_c = 0;
		$abn_p = 0;
		$abn_cap=0;
		$nv_int = 0;
		$cambio_estado = null;
		$pago_deuda = "";
		$prox_interes = null;
		$nv_in_m = 0;
		
		$con_abn  = Prestamo::select("prestamo_abonos.*","abono_prestamo.*")
		->join("prestamo_abonos","prestamo.id","=","prestamo_abonos.prestamo_id")
		->join("abono_prestamo","prestamo_abonos.abono_prestamo_id","=","abono_prestamo.id")
		->where("prestamo_abonos.prestamo_id","=",$id_prestamo)
		->orderBy('prestamo_abonos.id','desc')
		->take(1)
		->get();
		
		$prestamo = Prestamo::select("prestamo.*","tasa_interes.interes as t_i")
		->join("tasa_interes","prestamo.tasa_interes_id","=","tasa_interes.id")
		->where("prestamo.id",$id_prestamo)
		->get();
		
		$t_pm = ($prestamo[0]->valor_prestamo + $prestamo[0]->valor_interes_mensual);
		
		/*En este primer if creo el abono por primera vez....*/
		
		if (count($con_abn) == null) {
			
			if ($prestamo != null) {
				
				if ($sal == $t_pm ) {
					
					$pago_deuda = Abono_prestamo::create([

						'abono_interes' => $prestamo[0]->valor_interes_mensual,
						'fecha' => $f_a,
						'saldo_prestamo' =>0,
						'abono_capital'=> $prestamo[0]->valor_prestamo,
						'valor_abono' => 	$sal
						]);
					
					if ($pago_deuda !=null) {
						
						$cambio_estado = Prestamo::where("prestamo.id",$id_prestamo)
						->update(["estado" => 2]);
					}
					
					if ($cambio_estado !=null) {
						
						$prox_interes = Prestamo_abonos::create([
							"prestamo_id" => $id_prestamo,
							"abono_prestamo_id" => $pago_deuda->id,
							"nuevo_interes_mensual" => 0,
							"estado_prestamo" => 2
							]);
					}
					if ($prox_interes != null ) {
						return json_encode(["resp" => 1]);
					}
				}
				
				elseif ($sal < $prestamo[0]->valor_interes_mensual ) {
					
					$interes_actual = ($prestamo[0]->valor_interes_mensual-$sal);
					
					$abn_p = Abono_prestamo::create([

						'abono_interes' => $interes_actual ,
						'fecha' => $f_a,
						'saldo_prestamo' => $prestamo[0]->valor_prestamo,
						'abono_capital'=> 0,
						'valor_abono' => $sal
						]);
					
					if ($abn_p !=null) {
						
						$pr_c = Prestamo_abonos::create([

							"prestamo_id" => $id_prestamo,
							"abono_prestamo_id" => $abn_p->id,
							"nuevo_interes_mensual" => ($interes_actual + $prestamo[0]->valor_interes_mensual),
							"fecha_cuota" => $date,
							"estado_prestamo"
							]);
					}
					if ($pr_c != null ) {
						
						return json_encode(["resp" => 1]);
					}
				}
				
				elseif ($sal > $prestamo[0]->valor_interes_mensual) {
					
					$abn_cap = ($sal - $prestamo[0]->valor_interes_mensual);
					
					if ($abn_cap > $prestamo[0]->valor_prestamo) {
						
						$abn_p = Abono_prestamo::create([

							'abono_interes' => $prestamo[0]->valor_interes_mensual,
							'fecha' => $f_a,
							'saldo_prestamo' => 0,
							'abono_capital'=> $prestamo[0]->valor_prestamo,
							'valor_abono' => 	$sal
							]);
					}
					
					if ($abn_p !=null) {
						
						$pr_c = Prestamo_abonos::create([

							"prestamo_id" => $id_prestamo,
							"abono_prestamo_id" => $abn_p->id,
							"nuevo_interes_mensual" => 0,
							"estado_prestamo" => 2
							]);
					}
					
					if ($pr_c !=null) {
						
						$cambio_estado = Prestamo::where("prestamo.id",$id_prestamo)
						->update(["estado" => 2]);
					}
					
					if ($cambio_estado != null ) {
						
						return json_encode(["resp" => 3,"sobr"=>($abn_cap - $prestamo[0]->valor_prestamo)]);
					}
				}
				
				elseif ($sal == $prestamo[0]->valor_interes_mensual) {
					
					$abn_p = Abono_prestamo::create([

						'abono_interes' => $sal,
						'fecha' => $f_a,
						'saldo_prestamo' => $prestamo[0]->valor_prestamo,
						'abono_capital'=> 0,
						'valor_abono' => $sal
						]);
					
					if ($abn_p  != null) {
						
						$pr_c = Prestamo_abonos::create([

							"prestamo_id" => $id_prestamo,
							"abono_prestamo_id" => $abn_p->id,
							"nuevo_interes_mensual" => $prestamo[0]->valor_interes_mensual,
							"fecha_cuota" => $date,
							"estado_prestamo"

							]);
					}
					
					if ($pr_c != null ) {
						
						return json_encode(["resp" => 1]);
					}
				}
				
				if ($sal > $prestamo[0]->valor_interes_mensual ) {
					
					$abn_cap = ($sal - ($prestamo[0]->valor_interes_mensual));
					
					if ( $abn_cap < $prestamo[0]->valor_prestamo ) {
						
						$abn_p = Abono_prestamo::create([

							'abono_interes' => $prestamo[0]->valor_interes_mensual,
							'fecha' =>$input["fecha"],
							'saldo_prestamo' =>($prestamo[0]->valor_prestamo - $abn_cap),
							'abono_capital'=> $abn_cap,
							'valor_abono' => $sal

							]);
						
						if(	$abn_p != null) {
							
							$nv_int = (($prestamo[0]->valor_prestamo - $abn_cap )* $prestamo[0]->t_i )/100;
							
							$pr_c = Prestamo_abonos::create([
								"prestamo_id" => $id_prestamo,
								"abono_prestamo_id" => $abn_p->id,
								"nuevo_interes_mensual" => $nv_int,
								"fecha_cuota" => $date,
								"estado_cuota"
								]);
						}
						
						if ($pr_c != null) {
							
							return json_encode(["resp"=>1]);
						}
					}
				}
			}
			
		}
		/*En este else creo los abonos a partir de una abono existente...*/
		else {
			
			$p = Prestamo::select("prestamo.*","prestamo_abonos.*","abono_prestamo.*","prestamo_abonos.id as id_cuota")
			->join("prestamo_abonos","prestamo.id","=","prestamo_abonos.prestamo_id")
			->join("abono_prestamo","prestamo_abonos.abono_prestamo_id","=","abono_prestamo.id")
			->where("prestamo_abonos.prestamo_id","=",$id_prestamo)
			->orderBy('prestamo_abonos.id','desc')
			->take(1)
			->get();
			
			$nv_in_m = $p[0]->nuevo_interes_mensual;
			$s_p = $p[0]->saldo_prestamo;
			$dato_presamo = 0;
			
			$dato_prestamo = ($nv_in_m + $s_p);
			
			if ($p != null) {
				
				if ($sal == $dato_prestamo) {
					
					$pago_deuda = Abono_prestamo::create([
						'abono_interes' => 	$nv_in_m,
						'fecha' => $input["fecha"],
						'saldo_prestamo' =>0,
						'abono_capital'=> $s_p,
						'valor_abono' => 	$sal
						]);
					
					if ($pago_deuda !=null) {
						
						$cambio_estado = Prestamo::where("prestamo.id",$id_prestamo)
						->update(["estado" => 2]);
					}
					
					if ($cambio_estado !=null) {
						
						// 						Cambio el estado de la cuota anterior...
						$this->cambiar_estado_cuota($p[0]->id_cuota);
						
						$prox_interes = Prestamo_abonos::create([

							"prestamo_id" => $id_prestamo,
							"abono_prestamo_id" => $pago_deuda->id,
							"nuevo_interes_mensual" => 0,
							"estado_cuota" => 2

							]);
					}
					if ($prox_interes != null ) {
						return json_encode(["resp" => 1]);
					}
				}
				
				elseif ($sal < $nv_in_m ) {
					
					$interes_actual = ($nv_in_m-$sal);
					
					$abn_p = Abono_prestamo::create([

						'abono_interes' => $sal ,
						'fecha' =>$input["fecha"],
						'saldo_prestamo' =>$s_p,
						'abono_capital'=> 0,
						'valor_abono' => 	$sal
						]);
					
					if ($abn_p !=null) {
						
						// 						Cambio el estado de la cuota anterior...
						$this->cambiar_estado_cuota($p[0]->id_cuota);
						
						$pr_c = Prestamo_abonos::create([

							"prestamo_id" => $id_prestamo,
							"abono_prestamo_id" => $abn_p->id,
							"nuevo_interes_mensual" => ($interes_actual + $nv_in_m),
							"fecha_cuota" => $date,
							"estado_cuota"

							]);
					}
					
					if ($pr_c != null ) {
						
						return json_encode(["resp" => 1]);
					}
				}
				
				elseif ($sal > $nv_in_m) {
					
					$abn_cap = ($sal - $nv_in_m);
					
					if ($abn_cap > $s_p) {
						
						$abn_p = Abono_prestamo::create([

							'abono_interes' => $nv_in_m,
							'fecha' => $f_a,
							'saldo_prestamo' => 0,
							'abono_capital'=> $s_p,
							'valor_abono' => $sal

							]);
					}
					
					if ($abn_p !=null) {
						
						// 						Cambio el estado de la cuota anterior...
						$this->cambiar_estado_cuota($p[0]->id_cuota);
						
						$pr_c = Prestamo_abonos::create([

							"prestamo_id" => $id_prestamo,
							"abono_prestamo_id" => $abn_p->id,
							"nuevo_interes_mensual" => 0,
							"estado_cuota" => 2

							]);
					}
					
					if ($pr_c !=null) {
						
						$cambio_estado = Prestamo::where("prestamo.id",$id_prestamo)
						->update(["estado" => 2]);
						
					}
					
					if ($cambio_estado != null ) {
						
						return json_encode(["resp" => 3,"sobr"=>($abn_cap - $s_p)]);
					}
				}
				
				elseif ($sal == $nv_in_m) {
					
					$abn_p = Abono_prestamo::create([

						'abono_interes' => $sal,
						'fecha' =>$input["fecha"],
						'saldo_prestamo' => $s_p,
						'abono_capital'=> 0,
						'valor_abono' => $sal
						]);
					
					if ($abn_p  != null) {
						
						// 						Cambio el estado de la cuota anterior...
						$this->cambiar_estado_cuota($p[0]->id_cuota);
						
						$pr_c = Prestamo_abonos::create([

							"prestamo_id" => $id_prestamo,
							"abono_prestamo_id" => $abn_p->id,
							"nuevo_interes_mensual" => $nv_in_m,
							"fecha_cuota" => $date,
							"estado_cuota"
							]);
					}
					
					if ($pr_c != null ) {
						
						return json_encode(["resp" => 1]);
					}
				}
				
				if ($sal > $nv_in_m ) {
					
					$abn_cap = ($sal - $nv_in_m);
					
					if ( $abn_cap < $s_p ) {
						
						$abn_p = Abono_prestamo::create([

							'abono_interes' =>  $nv_in_m,
							'fecha' =>$input["fecha"],
							'saldo_prestamo' =>($s_p - $abn_cap),
							'abono_capital'=> $abn_cap,
							'valor_abono' => 	$sal

							]);
						
						if(	$abn_p != null) {
							
							// 							Cambio el estado de la cuota anterior...
							$this->cambiar_estado_cuota($p[0]->id_cuota);
							
							$nv_int = (($s_p - $abn_cap ) * $prestamo[0]->t_i )/100;
							
							$pr_c = Prestamo_abonos::create([
								"prestamo_id" => $id_prestamo,
								"abono_prestamo_id" => $abn_p->id,
								"nuevo_interes_mensual" => $nv_int,
								"fecha_cuota" => $date,
								"estado_cuota"
								]);
						}
						
						if ($pr_c != null) {
							
							return json_encode(["resp"=>1]);
						}
					}
				}
				
			}
			
			else{
				
				return false;
			}
			
		}
	}
	
	public function cambiar_estado_cuota($prestamo_abonos_id){
		
		$cambio_estado_cuota = Prestamo_abonos::where("prestamo_abonos.id",$prestamo_abonos_id)
		->update(["estado_cuota" => 2]);
	}
	
	public function consultar_abonos() {
		
		$clientes =  $clientes = Cliente::select("clientes.*")
    ->join("prestamo","clientes.id","=","prestamo.clientes_id")
    ->join("prestamo_abonos","prestamo.id","=","prestamo_abonos.prestamo_id")
    ->join("abono_prestamo","prestamo_abonos.abono_prestamo_id","=","abono_prestamo.id")
    ->where('clientes.estado',"=",1)
    ->where('prestamo.estado',1)
    ->where('prestamo_abonos.estado_cuota',"=",1)
    ->get();
    
		return view("consultar_abonos", compact("clientes"));
		
	}
	
	public function detalle_abonos ($id){
		
		$de_pre = Cliente::select("clientes.*","prestamo.*","prestamo_abonos.*","abono_prestamo.*","abono_prestamo.id as id_abono")
		->join("prestamo","clientes.id","=","prestamo.clientes_id")
		->join("prestamo_abonos","prestamo.id","=","prestamo_abonos.prestamo_id")
		->join("abono_prestamo","prestamo_abonos.abono_prestamo_id","=","abono_prestamo.id")
		->where("prestamo_abonos.prestamo_id","=",$id)
		->orderBy('prestamo_abonos.id','ASC')
		->get();
		
		$t_abn = 0;
		$t_abn_i = 0;
		
		foreach ($de_pre as $value) {
			$t_abn += $value->abono_capital;
			$t_abn_i += $value->abono_interes;
		}
		
		if (count($de_pre)>0) {
			$nombre = $de_pre[0]->nombre." ".$de_pre[0]->primer_apellido;
			return view("detalle_abonos", compact("de_pre","nombre", "id"));
		}
		else{
			Notify::info("No se encontraron datos","Consultar abono");
			return redirect()->route("/consultar/abonos");
		}
		
	}
	
	
	public function estado_prestamo($id) {
		
		$de_pre = Cliente::select("clientes.*","prestamo.*","prestamo_abonos.*","abono_prestamo.*","abono_prestamo.id as id_abono")
		->join("prestamo","clientes.id","=","prestamo.clientes_id")
		->join("prestamo_abonos","prestamo.id","=","prestamo_abonos.prestamo_id")
		->join("abono_prestamo","prestamo_abonos.abono_prestamo_id","=","abono_prestamo.id")
		->where("prestamo_abonos.prestamo_id","=",$id)
		->orderBy('prestamo_abonos.id','ASC')
		->get();
		
		$abono_capital = 0;
		$interes = 0;
		$datos = [];
		
		foreach ($de_pre as $valor) {
			$abono_capital += $valor->abono_capital;
			$interes += $valor->abono_interes;
		}
		array_push($datos,["abono_capital"=>$abono_capital,"interes"=>$interes]);
		
		return json_encode($datos);
	}
	
	public function consultar_proxima_cuota(Request $dato){
		
		$proxima_cuota = Cliente::select("prestamo.estado","prestamo_abonos.*")
		->join("prestamo","clientes.id","=","prestamo.clientes_id")
		->join("prestamo_abonos","prestamo.id","=","prestamo_abonos.prestamo_id")
		->join("abono_prestamo","prestamo_abonos.abono_prestamo_id","=","abono_prestamo.id")
		->where("prestamo_abonos.prestamo_id","=",$dato->input("id_prestamo"))
		->orderBy('prestamo_abonos.id','DESC')
		->get();
		
		return json_encode($proxima_cuota);
		
	}
	
	public function sumarMes(Request $id) {
		
		$date_actual = Carbon::now();
		$f_parseada = $date_actual->format('Y-m-d');
		$date_ac =  Carbon::now();
		$date = $date_ac->addMonth()->format('Y-m-d');
		
		$con_abn  = Prestamo::select("prestamo_abonos.*","abono_prestamo.*","prestamo_abonos.id as id_cuota")
		->join("prestamo_abonos","prestamo.id","=","prestamo_abonos.prestamo_id")
		->join("abono_prestamo","prestamo_abonos.abono_prestamo_id","=","abono_prestamo.id")
		->where("prestamo_abonos.prestamo_id","=",$id->input("id"))
		->where('estado_cuota','1')
		->get();
		
		$abn_p = Abono_prestamo::create([

			'abono_interes' => $con_abn[0]->nuevo_interes_mensual,
			'fecha' => $f_parseada,
			'saldo_prestamo' => $con_abn[0]->saldo_prestamo,
			'abono_capital'=> 0,
			'valor_abono' => $con_abn[0]->nuevo_interes_mensual
			]);
		
		if ($abn_p  != null) {
			
			//C			ambio el estado de la cuota anterior...
			$this->cambiar_estado_cuota($con_abn[0]->id_cuota);
			
			$pr_c = Prestamo_abonos::create([

				"prestamo_id" => $id->input("id"),
				"abono_prestamo_id" => $abn_p->id,
				"nuevo_interes_mensual" => $con_abn[0]->nuevo_interes_mensual,
				"fecha_cuota" => $date,
				"estado_cuota"
				]);
		}
		
		if ($pr_c != null ) {
			return json_encode(["resp" => 1]);
		}
	}
}
