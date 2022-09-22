<?php

namespace App\Http\Controllers;
use App\Models\CambiossistemaModel;
use DB;

use Illuminate\Http\Request;

class CambiossistemaController extends Controller
{
    public function cambiar(Request $request){
        $actualizar_area= CambiossistemaModel::findOrFail(1);
        $actualizar_area->valor=$request->estado;
        $actualizar_area->save();
        return response(0);
    }

    public function obtener_cambio(){
        $respuesta=DB::table("cambios")->select("valor")->first();
        return response($respuesta->valor);
    }
}
