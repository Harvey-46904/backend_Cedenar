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
}
