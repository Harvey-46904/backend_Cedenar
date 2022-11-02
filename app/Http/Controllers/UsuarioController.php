<?php

namespace App\Http\Controllers;
use App\Models\UsuarioModel;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RecuperarContrasena;
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


    public function enviar_correo(Request $request){
        
        $validar=DB::table("usuario")
        ->select()
        ->where("email_usuario","=",$request->email)
        ->first();
        if($validar!=null){
            $cifrar=base64_encode($validar->id_usuario);
            $cifrar=base64_encode($cifrar);
            Mail::to("harveympv@hotmail.com")->send(new RecuperarContrasena("http://localhost:4200/login/renovar-contrasena/".$cifrar));
            return response(["status"=>0]);
        }else{
            return response(["status"=>1]);
        }

        
    }

    public function cambio_contra(Request $request){
     
        $token=$request->token;
        $passworod=$request->password;
        $descifrar=base64_decode($token);
        $descifrar=base64_decode($descifrar);
        $cambiar_contra=UsuarioModel::findOrFail($descifrar);
        if($cambiar_contra!=null){
            $cambiar_contra->password_usuario=md5($passworod);
            $cambiar_contra->save();
            return response(["status"=>0,"data"=>["email"=> $cambiar_contra->password_usuario, "password"=> $cambiar_contra->password_usuario]]);
        }else{
            return response(["status"=>1,"data"=>["email"=>"harveympv@hotmail.com", "password"=>"M@uricio"]]);
        }
      
    }
}
