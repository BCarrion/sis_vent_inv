<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $table='articulo';
    protected $primaryKey='idarticulo';
    public $timestamps=false;

    protected fillable=[
      'codigo',
      'nombre',
      'cantidad',
      'descripcion',
      'imagen',
      'estado'
    ];
}
