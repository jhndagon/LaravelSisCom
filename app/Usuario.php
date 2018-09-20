<?php

namespace Comisiones;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Usuario extends Model implements AuthenticatableContract
{
    use Authenticatable;
    protected $table='usuarios';
    public $timestamps = false;



    //Los tres métodos que siguen permiten no guardar token en la base de datos.
    public function getRememberToken()    {
        return $this->token;
    }
    public function setRememberToken($value)    {
        $this->token = $value;
    }
    public function getRememberTokenName()    {
        return 'token';
    }
}
