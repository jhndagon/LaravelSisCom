<?php

namespace Comisiones;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Profesor extends Authenticatable
{
    use Notifiable;

    protected $table='Profesores';
    public $timestamps = false;
    protected $primaryKey = 'cedula';

    protected $guard = "profesor";

    protected $attributes = ['nombre','email','pass','cedula'];

    //Los tres métodos que siguen permiten no guardar token en la base de datos.
    public function getRememberToken()    {
        return null;
    }
    public function setRememberToken($value)    {
    }
    public function getRememberTokenName()    {
        return null;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cedula', 'nombre', 'email', 'tipo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function getAuthPassword() {
        return $this->pass;
    }
}
