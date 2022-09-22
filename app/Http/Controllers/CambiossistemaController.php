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

    public function pdf1(){

        $public_path = public_path();
        $url = $public_path.'/storage/pdf/Manual del Visitante cliente usuario_v1.pdf';// depende de root en el archivo filesystems.php.
        //verificamos si el archivo existe y lo retornamos
     
            return response()->download($url);
        
       
      
        
    }
    public function pdf2(){
        $public_path = public_path();
        $url = $public_path.'/storage/pdf/Manual del usuario_v2.pdf';// depende de root en el archivo filesystems.php.
        //verificamos si el archivo existe y lo retornamos
     
            return response()->download($url);
        
    }
}
