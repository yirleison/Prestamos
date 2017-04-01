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
        'clientes_id',
        'tasa_interes_id',
      ];
    public $timestamps = false;
}
