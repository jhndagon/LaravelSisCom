<?php

namespace Comisiones;

use Illuminate\Database\Eloquent\Model;

class Comision extends Model
{
    protected $table='Comisiones';
    public $timestamps = false;
    protected $primaryKey = 'comisionid';
    public $keyType = 'string';

}
