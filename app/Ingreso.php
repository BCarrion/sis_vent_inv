<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table='ingreso';
    protected $primaryKey='idingreso';
    public $timestamps=false;

    protected $fillable=[
      'tipo_comprobante',
      'serie_comprobante',
      'num_comprobante',
      'fecha_hora',
      'impuesto',
      'valor',
      'estado'
    ];
}
