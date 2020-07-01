<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'venta';

    protected $primaryKey = 'idventa';

    public $timestamps = false;

    protected $guarded = ['idventa'];
}
