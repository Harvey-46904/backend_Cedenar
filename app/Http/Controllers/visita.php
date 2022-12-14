<?php

namespace App\Http\Controllers;

use App\Models\VisitaModel;
use Illuminate\Http\Request;
use DB;
class visita extends Controller
{
    public function ObtenerTipooVisitante(){
        $tipo=DB::table("tipovisitante")->
        select("id_tipo_visitante as id","descripcion")->
        get();
        $respuesta=DB::table("cambios")->select("valor")->first();
       $respuesta=$respuesta->valor==0?"desaparecer":"aparecer";
        return response([
            "status"=>0,
            "msj"=>"tipos de visitantes cargados correctamente",
            "data"=>$tipo,
            "validar"=>$respuesta
            ]
        );
    }

    public function GuardarVisitantes(Request $request){
      //  return response(["data"=>$request->tipoVisitante]);
        $ldate = date('Y-m-d-H_i_s');
        $crear_visitante=new VisitaModel;
        $crear_visitante->id_tipo_visitante=$request->tipoVisitante;
        $crear_visitante->genero=$request->tipo_genero;
        $crear_visitante->created_on=$ldate;
        $crear_visitante->save();
        return response(["data"=>1]);
       // $crear_visitante->id_tipo_visitante;
        //$crear_visitante->created_on;
        		
    }
}
