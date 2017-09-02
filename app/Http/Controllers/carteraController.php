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
use App\models\Usuarios;

class carteraController extends Controller
{
	public function index(){

		$d = [];

		$meses = ['01' => "Enero",'02' => "Febrero",'03' => "Marzo",'04' => "Abril",'05' => "Mayo",'06' => "Junio",'07' =>"Julio",'08' => "Agosto",'09' => "Septiembre",'10' => "Octubre",'11' => "Noviembre", '12' => "Diciembre"];

		foreach ($meses as $key => $val) {

			$datos = DB::table('abono_prestamo')
			->whereMonth('fecha', $key)
			->get();

			array_push($d,[$key => $datos, "mes" => $meses[$key]]);
		}

		return view("cartera",compact("d"));
	}

}

