<?php

namespace App\Http\Controllers;
use App\Models\AreasModel;
use DB;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function getAreas(){
        $areas=DB::table("area")->select()->get();
        return response([
            "status"=>0,
            "msj"=>"Areas Cargadas Correctamente",
            "data"=>$areas
        ]);
    }

   public function createArea(Request $request){
   
    $nueva_area=new AreasModel;
    $nueva_area->nombre_area=$request->nombre;
    $nueva_area->descripcion_area=$request->descripcion;
    $nueva_area->save();
    return response(["data"=>0]);
   }

   public function updateArea (Request $request,$id){
        $actualizar_area= AreasModel::findOrFail($id);
        $actualizar_area->nombre_area=$request->nombre;
        $actualizar_area->descripcion_area=$request->descripcion;
        $actualizar_area->save();
        return response(["data"=>0]);
   }

   public function deleteArea ($id){

    $oficinas=DB::table("oficina")->select()->where("id_area","=",$id)->get();
    if($oficinas==null){
        $eliminar_area= AreasModel::findOrFail($id);
        $eliminar_area->delete();
        return response(["status"=>0]);
    }else{
        return response(["status"=>1]);
    }
      
   }
    
    /*
areaRouter.get("/buscar/:termino", areaCtrl.buscarArea);*/
}
