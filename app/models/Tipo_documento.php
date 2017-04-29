<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Tipo_documento extends Model
{
    protected $table ="tipo_documento";

    protected $fillable = [
      'tipo_documento'
    ];
    public $timestamps = false;
}
