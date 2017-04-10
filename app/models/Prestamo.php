<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    protected $table = 'prestamo';

    protected $fillable = [
        'valor_prestamo',
        'fecha_prestamo',
        'plazo',
        'fecha_fin',
        'total_intereses',
        'valor_pagar',
        'estado',
        'clientes_id',
        'tasa_interes_id',
        'tipo_prestamo',
        'valor_interes_mensual'
      ];
    public $timestamps = false;
}
