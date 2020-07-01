<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalle_venta';

    protected $primaryKey = 'iddetalle_venta';

    public $timestamps = false;

    protected $guarded = ['iddetalle_venta'];
}
