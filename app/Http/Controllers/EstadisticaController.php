<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class EstadisticaController extends Controller
{
    
    public function estadistica_general($tipo){
        $array_tipo=explode("&",$tipo);
        $tipo=$array_tipo[0];
        $cantidad=5;
        $desde=$array_tipo[1];
       $hasta=$array_tipo[2];

       if($desde == "" || $hasta == ""){
           switch ($tipo) {
            case 'Todo':
              
                $general=DB::table("visita")
                ->selectRaw('SUM(id_tipo_visitante) as f')
                ->groupBy('id_tipo_visitante')
                ->get();
               
                $contador_visitas=array(
                    "Visita"=>$general[0]->f,
                    "Cliente"=>$general[1]->f/2,
                   "Usuario"=>$general[2]->f/3,
                   "suma"=>$general[0]->f+($general[1]->f/2)+($general[2]->f/3)
                );
              
                $recurrentes=DB::table("lugar_visita")
                ->selectRaw('nombre_lugar')
                ->selectRaw('COUNT(*) as total')
                ->groupBy('nombre_lugar')
                ->orderBy("total", "desc")
                ->take($cantidad)
                ->get();

               $genero=self::get_genero_sinfecha();
                return response([
                   "general"=>$contador_visitas,
                   "lugares_recurrentes"=>$recurrentes,
                   "generos"=>$genero
                ]);
                break;
            case 'Visitantes':
                $general=DB::table("visita")
                ->selectRaw('SUM(id_tipo_visitante) as f')
                ->groupBy('id_tipo_visitante')
                ->get();
                $contador_visitas=array(
                "Visita"=>$general[0]->f,
                "Cliente"=>0,
                "Usuario"=>0,
                "suma"=>$general[0]->f
                );
                $recurrentes=DB::table("lugar_visita")
                ->selectRaw('nombre_lugar')
                ->selectRaw('COUNT(*) as total')
                ->where("tipovisitante_lugar","=","1")
                ->groupBy('nombre_lugar')
                ->orderBy("total", "desc")
                ->take($cantidad)
                ->get();
               $genero=self::get_genero_sinfecha();
                return response([
                   "general"=>$contador_visitas,
                   "lugares_recurrentes"=>$recurrentes,
                   "generos"=>$genero
                ]);
                break;
            case 'Clientes':
                $general=DB::table("visita")
                ->selectRaw('SUM(id_tipo_visitante) as f')
                ->groupBy('id_tipo_visitante')
                ->get();
                $contador_visitas=array(
                    "Visita"=>0,
                    "Cliente"=>$general[1]->f/2,
                    "Usuario"=>0,
                    "suma"=>($general[1]->f/2)
                );
                $recurrentes=DB::table("lugar_visita")
                ->selectRaw('nombre_lugar')
                ->selectRaw('COUNT(*) as total')
                ->where("tipovisitante_lugar","=","2")
                ->groupBy('nombre_lugar')
                ->orderBy("total", "desc")
                ->take($cantidad)
                ->get();
                $genero=self::get_genero_sinfecha();
                return response([
                   "general"=>$contador_visitas,
                   "lugares_recurrentes"=>$recurrentes,
                   "generos"=>$genero
                ]);
                    break;
            case 'Usuarios':
                $general=DB::table("visita")
                ->selectRaw('SUM(id_tipo_visitante) as f')
                ->groupBy('id_tipo_visitante')
                ->get();
                $contador_visitas=array(
                "Visita"=>0,
                "Cliente"=>0,
                "Usuario"=>$general[2]->f/3,
                "suma"=>($general[2]->f/3)
                );
                $recurrentes=DB::table("lugar_visita")
                ->selectRaw('nombre_lugar')
                ->selectRaw('COUNT(*) as total')
                ->where("tipovisitante_lugar","=","3")
                ->groupBy('nombre_lugar')
                ->orderBy("total", "desc")
                ->take($cantidad)
                ->get();
                $genero=self::get_genero_sinfecha();
                return response([
                   "general"=>$contador_visitas,
                   "lugares_recurrentes"=>$recurrentes,
                   "generos"=>$genero
                ]);
                break;
           
        }
       }else{
          switch ($tipo) {
            case 'Todo':
              
                $general=DB::table("visita")
                ->selectRaw('SUM(id_tipo_visitante) as f')
                ->where(function($query) use ($desde,$hasta){
                    $query->whereBetween('visita.created_on', [$desde, $hasta]);
                })
                ->groupBy('id_tipo_visitante')
                ->get();
                $a=(!isset($general[0]->f))?0:$general[0]->f;
                $b=(!isset($general[1]->f))?0:$general[1]->f;
                $c=(!isset($general[2]->f))?0:$general[2]->f;
                $contador_visitas=array(
                    "Visita"=>$a,
                    "Cliente"=>$b/2,
                   "Usuario"=>$c/3,
                   "suma"=>$a+($b/2)+($c/3)
                );
                
              
                $recurrentes=DB::table("lugar_visita")
                ->selectRaw('nombre_lugar')
                ->selectRaw('COUNT(*) as total')
                ->groupBy('nombre_lugar')
                ->orderBy("total", "desc")
                ->take($cantidad)
                ->get();

                $genero=self::get_genero($desde,$hasta);
                
                return response([
                   "general"=>$contador_visitas,
                   "lugares_recurrentes"=>$recurrentes,
                   "generos"=>$genero
                ]);
                break;
            case 'Visitantes':
                $general=DB::table("visita")
                ->selectRaw('SUM(id_tipo_visitante) as f')
                ->where(function($query) use ($desde,$hasta){
                    $query->whereBetween('visita.created_on', [$desde, $hasta]);
                })
                ->groupBy('id_tipo_visitante')
                ->get();
                $a=(!isset($general[0]->f))?0:$general[0]->f;
                $b=(!isset($general[1]->f))?0:$general[1]->f;
                $c=(!isset($general[2]->f))?0:$general[2]->f;
                $contador_visitas=array(
                    "Visita"=>$a,
                    "Cliente"=>0,
                   "Usuario"=>0,
                   "suma"=>$a
                );
                $recurrentes=DB::table("lugar_visita")
                ->selectRaw('nombre_lugar')
                ->selectRaw('COUNT(*) as total')
                ->where("tipovisitante_lugar","=","1")
                ->groupBy('nombre_lugar')
                ->orderBy("total", "desc")
                ->take($cantidad)
                ->get();

                $genero=self::get_genero($desde,$hasta);
                
                return response([
                   "general"=>$contador_visitas,
                   "lugares_recurrentes"=>$recurrentes,
                   "generos"=>$genero
                ]);
                break;
            case 'Clientes':
                $general=DB::table("visita")
                ->selectRaw('SUM(id_tipo_visitante) as f')
                ->where(function($query) use ($desde,$hasta){
                    $query->whereBetween('visita.created_on', [$desde, $hasta]);
                })
                ->groupBy('id_tipo_visitante')
                ->get();
                $a=(!isset($general[0]->f))?0:$general[0]->f;
                $b=(!isset($general[1]->f))?0:$general[1]->f;
                $c=(!isset($general[2]->f))?0:$general[2]->f;
                $contador_visitas=array(
                    "Visita"=>0,
                    "Cliente"=>$b/2,
                   "Usuario"=>0,
                   "suma"=>($b/2)
                );
                $recurrentes=DB::table("lugar_visita")
                ->selectRaw('nombre_lugar')
                ->selectRaw('COUNT(*) as total')
                ->where("tipovisitante_lugar","=","2")
                ->groupBy('nombre_lugar')
                ->orderBy("total", "desc")
                ->take($cantidad)
                ->get();
                $genero=self::get_genero($desde,$hasta);
                
                return response([
                   "general"=>$contador_visitas,
                   "lugares_recurrentes"=>$recurrentes,
                   "generos"=>$genero
                ]);
                    break;
            case 'Usuarios':
                $general=DB::table("visita")
                ->selectRaw('SUM(id_tipo_visitante) as f')
                ->where(function($query) use ($desde,$hasta){
                    $query->whereBetween('visita.created_on', [$desde, $hasta]);
                })
                ->groupBy('id_tipo_visitante')
                ->get();
                $a=(!isset($general[0]->f))?0:$general[0]->f;
                $b=(!isset($general[1]->f))?0:$general[1]->f;
                $c=(!isset($general[2]->f))?0:$general[2]->f;
                $contador_visitas=array(
                    "Visita"=>0,
                    "Cliente"=>0,
                   "Usuario"=>$c/3,
                   "suma"=>($c/3)
                );
                $recurrentes=DB::table("lugar_visita")
                ->selectRaw('nombre_lugar')
                ->selectRaw('COUNT(*) as total')
                ->where("tipovisitante_lugar","=","3")
                ->groupBy('nombre_lugar')
                ->orderBy("total", "desc")
                ->take($cantidad)
                ->get();
                $genero=self::get_genero($desde,$hasta);
                
                return response([
                   "general"=>$contador_visitas,
                   "lugares_recurrentes"=>$recurrentes,
                   "generos"=>$genero
                ]);
                break;
           
        }
       }
      
    }

    public function get_genero($desde,$hasta){
        $genero=DB::table("visita")
        ->select('genero')
        ->selectRaw("COUNT(CASE WHEN genero = 'M' THEN 1 ELSE NULL END) AS male")
        ->selectRaw("COUNT(CASE WHEN genero = 'F' THEN 1 ELSE NULL END) AS female")
        ->selectRaw("COUNT(CASE WHEN genero = 'M' AND id_tipo_visitante=1 THEN 1 ELSE NULL END) AS visita_Hombre")
        ->selectRaw("COUNT(CASE WHEN genero = 'M' AND id_tipo_visitante=2 THEN 1 ELSE NULL END) AS cliente_Hombre")
        ->selectRaw("COUNT(CASE WHEN genero = 'M' AND id_tipo_visitante=3 THEN 1 ELSE NULL END) AS usuario_Hombre")
        ->selectRaw("COUNT(CASE WHEN genero = 'F' AND id_tipo_visitante=1 THEN 1 ELSE NULL END) AS visita_mujer")
        ->selectRaw("COUNT(CASE WHEN genero = 'F' AND id_tipo_visitante=2 THEN 1 ELSE NULL END) AS cliente_mujer")
        ->selectRaw("COUNT(CASE WHEN genero = 'F' AND id_tipo_visitante=3 THEN 1 ELSE NULL END) AS usuario_mujer")
        ->where(function($query) use ($desde,$hasta){
            $query->whereBetween('visita.created_on', [$desde, $hasta]);
        })
        ->groupBy('genero')
        ->get();
        return $genero;
    }
    public function get_genero_sinfecha(){
        $genero=DB::table("visita")
        ->select('genero')
        ->selectRaw("COUNT(CASE WHEN genero = 'M' THEN 1 ELSE NULL END) AS male")
        ->selectRaw("COUNT(CASE WHEN genero = 'F' THEN 1 ELSE NULL END) AS female")
        ->selectRaw("COUNT(CASE WHEN genero = 'M' AND id_tipo_visitante=1 THEN 1 ELSE NULL END) AS visita_Hombre")
        ->selectRaw("COUNT(CASE WHEN genero = 'M' AND id_tipo_visitante=2 THEN 1 ELSE NULL END) AS cliente_Hombre")
        ->selectRaw("COUNT(CASE WHEN genero = 'M' AND id_tipo_visitante=3 THEN 1 ELSE NULL END) AS usuario_Hombre")
        ->selectRaw("COUNT(CASE WHEN genero = 'F' AND id_tipo_visitante=1 THEN 1 ELSE NULL END) AS visita_mujer")
        ->selectRaw("COUNT(CASE WHEN genero = 'F' AND id_tipo_visitante=2 THEN 1 ELSE NULL END) AS cliente_mujer")
        ->selectRaw("COUNT(CASE WHEN genero = 'F' AND id_tipo_visitante=3 THEN 1 ELSE NULL END) AS usuario_mujer")
        ->groupBy('genero')
        ->get();
        return $genero;
    }
}
