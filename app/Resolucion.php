<?php

namespace Comisiones;

use Illuminate\Database\Eloquent\Model;

class Resolucion extends Model
{
    protected $table='Resoluciones';
    public $timestamps = false;
    protected $primaryKey = 'resolucionid';
    public $keyType = 'string';
    
}


