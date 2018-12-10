<?php
namespace Comisiones\Exports;


use Comisiones\Comision;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromArray;

class ComisionesExport implements FromArray
{

    public $informacion;

    public function __construct($informacion){
        $this->informacion = $informacion;
    }

    public function array(): array
    {
        $info = json_decode($this->informacion);
        $opcion = $info->opcion;
        $comisiones = null;
        $esquema = Schema::getColumnListing('Comisiones');
        if($opcion == 'todas'){
            $comisiones = Comision::where('cedula','like','%');
        }
        else if($opcion == 'permisos'){
            $comisiones = Comision::where('tipocom', 'noremunerada')->orWhere('tipocom','calamidad');
        }
        else if($opcion == 'cedula'){
            if($busqueda){
                $comisiones = Comision::where('cedula', 'like', $busqueda.'%');
            }
            else {
                return back()->withErrors(['busqueda'=>'No se ha ingresado un número de cedula en el campo buscar.']);
            }
        }
        else if($opcion == 'fecha'){
            
            $fechas = explode(' a ', $info->fecha);
            $comisiones = Comision::where('fechaini', '>=' , $fechas[0])
                                  ->Where('fechafin','<=', $fechas[1]);
            
        }
        $comisiones->where(function($q) use ($info){
            if($info->institutos==null){
                $q->orwhere('cedula', 'like','%');
            }else{

                foreach($info->institutos as $instituto){
                    $q->orWhere('institutoid', $instituto);
                }
            }
        });
        $comisiones->where(function($q) use ($info){
            if($info->tipocom==null){
                $q->orwhere('cedula', 'like','%');
            }else{
                foreach($info->tipocom as $tipo){
                    $q->orWhere('tipocom', $tipo);
                }
            }
        });
        
        $comisiones = $comisiones->get()->toArray();
        array_unshift($comisiones, $esquema);
        return $comisiones;
    }
}