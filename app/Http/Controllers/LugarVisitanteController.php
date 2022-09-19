<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


use App\Models\LugarVisitanteModel;
use DB;


class LugarVisitanteController extends Controller
{

    public function agregar_lugar(Request $request){
      
        $now = new \DateTime();
        $crear_lugar=new LugarVisitanteModel;
        $crear_lugar->nombre_lugar=$request->nombre_oficina;
        $crear_lugar->tipovisitante_lugar=(int) $request->tipo_visitante;
        $crear_lugar->fecha_visita=$now->format('Y-m-d H:i:s');
        $crear_lugar->save();
        return response(["data"=>$request->all()]);
    }
}
