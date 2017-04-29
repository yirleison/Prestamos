<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
  protected $table = 'clientes';

  public $fillable = [

    'nombre',
    'primer_apellido',
    'segundo_apellido',
    'documento',
    'direccion',
    'telefono',
    'celular',
    'email',
    'estado',
    'tipo_documento_id',
  ];

  public $timestamps = false;

}
