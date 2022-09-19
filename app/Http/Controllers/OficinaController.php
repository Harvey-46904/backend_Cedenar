<?php

namespace App\Http\Controllers;
use App\Models\OficinaModel;
use DB;
use Illuminate\Http\Request;

class OficinaController extends Controller
{
     
    public function getOficinas (){
        $oficinas=DB::table("oficina")->select()->get();
        return response(
            [
            "status"=>0,
            "msj"=>"Oficinas Cargadas Correctamente",
            "data"=>$oficinas
            ]
        );

    }
    public function getOficina ($id){
        
    }
    public function createOficina (Request $request){
        $ldate = date('Y-m-d-H_i_s');
      

        $file = $request->file('imagen');
        $nombre = $file->getClientOriginalName();
        
    \Storage::disk('local')->put($ldate.$nombre,  \File::get($file));
    $guardar_oficina=new OficinaModel;
        
    $guardar_oficina->imagen_oficina=$ldate.$nombre;
    $guardar_oficina->nombre_oficina=$request->nombre;
    $guardar_oficina->descripcion_oficina=$request->descripcion;
    $guardar_oficina->piso_oficina=$request->piso;
    $guardar_oficina->latitud_oficina=$request->latitud;
    $guardar_oficina->longitud_oficina=$request->longitud;
    $guardar_oficina->id_area=$request->area;
    $guardar_oficina->created_on="2002-09-08";
    $guardar_oficina->estado_oficina=1;
    $guardar_oficina->save();
    return response(["data"=>0]);	
    	
    }
    public function updateOficina (Request $request,$id){
     
        $now = new \DateTime();
        $actualizar_area= OficinaModel::findOrFail($id);

        if($request->imagen!=null){
            $ldate = date('Y-m-d-H_i_s');
            $file = $request->file('imagen');
            $nombre = $file->getClientOriginalName();     
            \Storage::disk('local')->put($ldate.$nombre,  \File::get($file));
            $actualizar_area->imagen_oficina=$ldate.$nombre;
        }
        
        $actualizar_area->nombre_oficina=$request->nombre;
        
        $actualizar_area->descripcion_oficina=$request->descripcion;
        $actualizar_area->piso_oficina=$request->piso;
        $actualizar_area->latitud_oficina=$request->latitud;
        $actualizar_area->longitud_oficina=$request->longitud;
        $actualizar_area->id_area=$request->area;
        $actualizar_area->created_on=$now->format('Y-m-d H:i:s');
        $actualizar_area->estado_oficina=1;
        $actualizar_area->save();
        return response(["data"=>0]);
    }
    public function deleteOficina ($id){
        $eliminar_area= OficinaModel::findOrFail($id);
        $eliminar_area->delete();
        return response(["data"=>0]);
        
    }
    public function getImagen (){
        
    }
    public function getOficinasPorAreas (){
        $datos=DB::table("area")->select("id_area as id","nombre_area as nombre")->get();
        for ($i=0; $i <sizeof($datos) ; $i++) { 
          //  return response(["data"=>$datos[$i]->id]);
            $oficina=DB::table("oficina")
            ->select("id_oficina","imagen_oficina as imagen","nombre_oficina","latitud_oficina","longitud_oficina","descripcion_oficina")
            ->where("id_area","=",$datos[$i]->id)
            ->get();
            $datos[$i]->oficinas=$oficina;
        }
        return response(["data"=>$datos]);
    }
    
    /*
    oficinaRouter.get("/", oficinaCtrl.getOficinas);
    oficinaRouter.get("/:id", oficinaCtrl.getOficina);
    oficinaRouter.post("/", [multer_1.default], oficinaCtrl.createOficina);
    oficinaRouter.put("/:id", [multer_1.default], oficinaCtrl.updateOficina);
    oficinaRouter.delete("/:id", oficinaCtrl.deleteOficina);
    oficinaRouter.get("/imagen/:nombre", oficinaCtrl.getImagen);
    oficinaRouter.get("/por/areas", oficinaCtrl.getOficinasPorAreas);*/
}
