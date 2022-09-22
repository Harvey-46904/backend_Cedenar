<?php

namespace App\Http\Controllers;
use App\Models\UsuarioModel;
use DB;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function login(Request $request){
       
        $validar=DB::table("usuario")
        ->select()
        ->where("email_usuario","=",$request->username)
        ->where("password_usuario","=",md5($request->password))
        ->first();

        if($validar==null){
            return response(3);
        }else{
            return response(0);
        }
       
    }

    public function crear_usuario(Request $request){
        $now = new \DateTime();
            $crear=new UsuarioModel;
         $crear->username_usuario=$request->nombres;
         $crear->password_usuario=md5($request->contrasena);
         $crear->email_usuario=$request->correo;
         $crear->created_on=$now->format('Y-m-d H:i:s');
         $crear->estado_usuario= 1;
         $crear->save();
         return response(0);
    }
}
