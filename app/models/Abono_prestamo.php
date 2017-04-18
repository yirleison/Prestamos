<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Abono_prestamo extends Model
{
    protected $table = 'abono_prestamo';

    protected $fillable = [
    'abono_interes',
    'fecha',
    'saldo_prestamo',
    'abono_capital',
    'valor_abono'
    ];

    public $timestamps = false;
}
