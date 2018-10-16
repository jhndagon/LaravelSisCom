<?php

namespace Comisiones;

use Illuminate\Database\Eloquent\Model;

class Instituto extends Model
{
    protected $table='Institutos';
    public $timestamps = false;
    protected $primaryKey = 'institutoid';
    public $keyType = 'string';
}
