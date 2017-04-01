<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
      protected $table = 'login';

      public $timestamps = false;

      protected $fillable = [
      'nombre',
      'email',
      'password',
      'estado',
      'rol_id',
      'estado'
    ];
}
