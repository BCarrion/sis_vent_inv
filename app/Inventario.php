<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table='inventario';
    protected $primaryKey='idinventario';
    public $timestamps=false;

    protected $fillable=[
      'serial'
    ];
}
