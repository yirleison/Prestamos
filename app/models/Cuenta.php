<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
  protected $table = 'cuenta';

  protected $fillable = [
    'numero',
    'tipo_cuenta_id',
    'clientes_id'
  ];

    public $timestamps = false;

}
