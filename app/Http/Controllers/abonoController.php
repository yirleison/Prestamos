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


class abonoController extends Controller
{
	public function index() {

		$clientes =  Cliente::all();
		return view("crear_abono", compact("clientes"));
	}

	// Metodo para crear los abonos a los respectivos prestamos

	public function registrar_abono(Request $datos){

		$input = $datos->all();
		$id_prestamo = $input["id_prestamo"];
		
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

		
		$prestamo = Prestamo::select("prestamo.*","tasa_interes.interes as t_i")
		->join("tasa_interes","prestamo.tasa_interes_id","=","tasa_interes.id")
		->first();

		$t_pm = ($prestamo->valor_prestamo + $prestamo->valor_interes_mensual);

		$con_abn  = Prestamo::select("prestamo_abonos.*","abono_prestamo.*")
		->join("prestamo_abonos","prestamo.id","=","prestamo_abonos.prestamo_id")
		->join("abono_prestamo","prestamo_abonos.abono_prestamo_id","=","abono_prestamo.id")
		->where("prestamo_abonos.prestamo_id","=",$id_prestamo)
		->orderBy('prestamo_abonos.id','desc')
		->take(1)
		->get();

		if (count($con_abn) == 0) {

			if ($prestamo != null) {

				if ($sal == $t_pm ) {
					
					$pago_deuda = Abono_prestamo::create([
						'abono_interes' => $prestamo->valor_interes_mensual,
						'fecha' =>$input["fecha"],
						'saldo_prestamo' =>0,
						'prestamo_id' =>	$id_prestamo,
						'abono_capital'=> $prestamo->valor_prestamo,
						'valor_abono' => 	$sal
						]);

					if ($pago_deuda !=null) {
						
						$cambio_estado = $prestamo
						->update(["estado" => 2]);

					}

					if ($cambio_estado !=null) {

						$prox_interes = Prestamo_abonos::create([
							"prestamo_id" => $id_prestamo,
							"abono_prestamo_id" => $pago_deuda->id,
							"nuevo_interes_mensual" => 0
							]);
					}
					if ($prox_interes != null ) {
						return json_encode(["resp" => 1]);
					}
				}

				elseif ($sal < $prestamo->valor_interes_mensual ) {

					$interes_actual = ($prestamo->valor_interes_mensual-$sal);

					$abn_p = Abono_prestamo::create([
						'abono_interes' => $interes_actual ,
						'fecha' =>$input["fecha"],
						'saldo_prestamo' => $prestamo->valor_prestamo,
						'prestamo_id' =>	$id_prestamo,
						'abono_capital'=> 0,
						'valor_abono' => 	$sal
						]);

					if ($abn_p !=null) {

						$pr_c = Prestamo_abonos::create([
							"prestamo_id" => $id_prestamo,
							"abono_prestamo_id" => $abn_p->id,
							"nuevo_interes_mensual" => ($interes_actual + $prestamo->valor_interes_mensual)
							]);
					}
					if ($pr_c != null ) {
						
						return json_encode(["resp" => 1]);
					}
				}	

				elseif ($sal > $prestamo->valor_interes_mensual) {

					$abn_cap = ($sal - $prestamo->valor_interes_mensual);

					if ($abn_cap > $prestamo->valor_prestamo) {

						$abn_p = Abono_prestamo::create([
							'abono_interes' => $prestamo->valor_interes_mensual,
							'fecha' =>$input["fecha"],
							'saldo_prestamo' => 0,
							'prestamo_id' =>	$id_prestamo,
							'abono_capital'=> $prestamo->valor_prestamo,
							'valor_abono' => 	$sal
							]);
					}				

					if ($abn_p !=null) {

						$pr_c = Prestamo_abonos::create([
							"prestamo_id" => $id_prestamo,
							"abono_prestamo_id" => $abn_p->id,
							"nuevo_interes_mensual" => 0
							]);
					}
					if ($pr_c !=null) {

						$cambio_estado = $prestamo
						->update(["estado" => 2]);

					}

					if ($cambio_estado != null ) {

						return json_encode(["resp" => 3,"sobr"=>($abn_cap - $prestamo->valor_prestamo)]);
					}
				}

				elseif ($sal == $prestamo->valor_interes_mensual) {

					$abn_p = Abono_prestamo::create([

						'abono_interes' => $sal,
						'fecha' =>$input["fecha"],
						'saldo_prestamo' => $prestamo->valor_prestamo,
						'prestamo_id' =>	$id_prestamo,
						'abono_capital'=> 0,
						'valor_abono' => 	$sal
						]);

					if ($abn_p  != null) {

						$pr_c = Prestamo_abonos::create([
							"prestamo_id" => $id_prestamo,
							"abono_prestamo_id" => $abn_p->id,
							"nuevo_interes_mensual" => $prestamo->valor_interes_mensual
							]);
					}

					if ($pr_c != null ) {

						return json_encode(["resp" => 1]);
					}
				}

				if ($sal > $prestamo->valor_interes_mensual ) {

					$abn_cap = ($sal - $prestamo->valor_interes_mensual);

					if ( $abn_cap < $prestamo->valor_prestamo ) {

						$abn_p = Abono_prestamo::create([

							'abono_interes' => $prestamo->valor_interes_mensual,
							'fecha' =>$input["fecha"],
							'saldo_prestamo' =>($prestamo->valor_prestamo - $abn_cap),
							'prestamo_id' =>	$id_prestamo,
							'abono_capital'=> $abn_cap,
							'valor_abono' => 	$sal
							]);

						if(	$abn_p != null) {

							$nv_int = (($prestamo->valor_prestamo - $abn_cap )* $prestamo->t_i )/100;

							$pr_c = Prestamo_abonos::create([
								"prestamo_id" => $id_prestamo,
								"abono_prestamo_id" => $abn_p->id,
								"nuevo_interes_mensual" => $nv_int

								]);
						}
						
						if ($pr_c != null) {

							return json_encode(["resp"=>1]);
						}
					}
				}			
			}
			
		}
		else{

			$p = Prestamo::select("prestamo.*","prestamo_abonos.*","abono_prestamo.*")
			->join("prestamo_abonos","prestamo.id","=","prestamo_abonos.prestamo_id")
			->join("abono_prestamo","prestamo_abonos.abono_prestamo_id","=","abono_prestamo.id")
			->where("prestamo_abonos.prestamo_id","=",$id_prestamo)
			->orderBy('prestamo_abonos.id','desc')
			->take(1)
			->get();

			$nv_in_m = $p[0]->nuevo_interes_mensual;
			$s_p = $p[0]->saldo_prestamo;
			$dato_presamo =0;

			$dato_prestamo = ($nv_in_m + $s_p);

			if ($p != null) {
				
				if ($sal == $dato_prestamo) {

					$pago_deuda = Abono_prestamo::create([
						'abono_interes' => 	$nv_in_m,
						'fecha' =>$input["fecha"],
						'saldo_prestamo' =>0,
						'prestamo_id' =>	$id_prestamo,
						'abono_capital'=> $s_p,
						'valor_abono' => 	$sal
						]);

					if ($pago_deuda !=null) {
						
						$cambio_estado = $prestamo
						->update(["estado" => 2]);

					}

					if ($cambio_estado !=null) {

						$prox_interes = Prestamo_abonos::create([
							"prestamo_id" => $id_prestamo,
							"abono_prestamo_id" => $pago_deuda->id,
							"nuevo_interes_mensual" => 0
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
						'prestamo_id' =>	$id_prestamo,
						'abono_capital'=> 0,
						'valor_abono' => 	$sal
						]);

					if ($abn_p !=null) {

						$pr_c = Prestamo_abonos::create([
							"prestamo_id" => $id_prestamo,
							"abono_prestamo_id" => $abn_p->id,
							"nuevo_interes_mensual" => ($interes_actual + $nv_in_m)
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
							'fecha' =>$input["fecha"],
							'saldo_prestamo' => 0,
							'prestamo_id' =>	$id_prestamo,
							'abono_capital'=> $s_p,
							'valor_abono' => 	$sal
							]);
					}				

					if ($abn_p !=null) {

						$pr_c = Prestamo_abonos::create([
							"prestamo_id" => $id_prestamo,
							"abono_prestamo_id" => $abn_p->id,
							"nuevo_interes_mensual" => 0
							]);
					}
					if ($pr_c !=null) {

						$cambio_estado = $prestamo
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
						'prestamo_id' =>	$id_prestamo,
						'abono_capital'=> 0,
						'valor_abono' => 	$sal
						]);

					if ($abn_p  != null) {

						$pr_c = Prestamo_abonos::create([
							"prestamo_id" => $id_prestamo,
							"abono_prestamo_id" => $abn_p->id,
							"nuevo_interes_mensual" => $nv_in_m
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
							'prestamo_id' =>	$id_prestamo,
							'abono_capital'=> $abn_cap,
							'valor_abono' => 	$sal
							]);

						if(	$abn_p != null) {

							$nv_int = (($s_p - $abn_cap ) * $prestamo->t_i )/100;

							$pr_c = Prestamo_abonos::create([
								"prestamo_id" => $id_prestamo,
								"abono_prestamo_id" => $abn_p->id,
								"nuevo_interes_mensual" => $nv_int

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

	public function consultar_abonos() {
		
		$clientes =  Cliente::all();
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

		if (count($de_pre)>0) {
			$nombre = $de_pre[0]->nombre." ".$de_pre[0]->primer_apellido;
			return view("detalle_abonos", compact("de_pre","nombre"));
		}
		else{
			Notify::info("No se encontraron datos","Consultar abono");
			return redirect()->route("/consultar/abonos");				
		}

	}

	public function editar_abono($id){
		$abn = Abono_prestamo::find($id);

		return json_encode($abn);
	}
}

