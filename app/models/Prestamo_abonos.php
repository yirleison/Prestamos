<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Prestamo_abonos extends Model
{
   protected $table = "prestamo_abonos";

   protected $fillable = 
   ["prestamo_id",
   "abono_prestamo_id",
   "nuevo_interes_mensual",
   "fecha_cuota",
   "estado_cuota"
   ];

   public $timestamps = false;

}
