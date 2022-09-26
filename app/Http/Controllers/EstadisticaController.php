<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class EstadisticaController extends Controller
{
    
    public function estadistica_general($tipo){
        $cantidad=5;
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
                return response([
                   "general"=>$contador_visitas,
                   "lugares_recurrentes"=>$recurrentes
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
                return response([
                "general"=>$contador_visitas,
                "lugares_recurrentes"=>$recurrentes
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
                return response([
                    "general"=>$contador_visitas,
                    "lugares_recurrentes"=>$recurrentes
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
                 return response([
                "general"=>$contador_visitas,
                "lugares_recurrentes"=>$recurrentes
                ]);
                break;
           
        }
    

    }
}
