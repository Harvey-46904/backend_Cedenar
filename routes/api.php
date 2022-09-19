<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/visita',"visita@ObtenerTipooVisitante");
Route::post('/visita',"visita@GuardarVisitantes");

Route::get("/area", "AreaController@getAreas");
Route::post("/area", "AreaController@createArea");
Route::put("/area/{id}", "AreaController@updateArea");
Route::delete("/area/{id}", "AreaController@deleteArea");


Route::get("/oficina","OficinaController@getOficinas");
Route::get("/oficina/{id}","OficinaController@getOficina");
Route::post("/oficina","OficinaController@createOficina");
Route::post("/oficinaupdate/{id}","OficinaController@updateOficina");
Route::delete("/oficina/{id}", "OficinaController@deleteOficina");
Route::get("/oficina/por/areas", "OficinaController@getOficinasPorAreas");

Route::post("/visitalugar","LugarVisitanteController@agregar_lugar");

Route::get("/estadistica/{tipo}", "EstadisticaController@estadistica_general");

Route::post("/logearse","UsuarioController@login");

/*
visitaRouter.get("/", visitanteCtrl.getTipoVisitantes);
visitaRouter.post("/", visitanteCtrl.registerVisita);
visitaRouter.get("/numero-visitantes", visitanteCtrl.getGrafico);
visitaRouter.get("/grafico-visitantes", visitanteCtrl.getGraficoVisitantesTiempoTipoVisitante);
visitaRouter.get("/ayuda", visitanteCtrl.getAyuda);
visitaRouter.get("/ayuda/app", visitanteCtrl.getAyudaApp);
//area

//auth
authRouter.post("/login", authCtrl.login);
authRouter.post("/register", authCtrl.register);
authRouter.get("/token", authCtrl.verificarToken);
authRouter.put("/enviar-correo", authCtrl.enviarCorreo);
authRouter.put("/renovar-contrasena", authCtrl.renovarContrasena);

//oficinas
oficinaRouter.get("/", oficinaCtrl.getOficinas);
oficinaRouter.get("/:id", oficinaCtrl.getOficina);
oficinaRouter.post("/", [multer_1.default], oficinaCtrl.createOficina);
oficinaRouter.put("/:id", [multer_1.default], oficinaCtrl.updateOficina);
oficinaRouter.delete("/:id", oficinaCtrl.deleteOficina);
oficinaRouter.get("/imagen/:nombre", oficinaCtrl.getImagen);
oficinaRouter.get("/por/areas", oficinaCtrl.getOficinasPorAreas);
//roles
rolRouter.get("/", rolCtrl.getRoles);
rolRouter.get("/:id", rolCtrl.getRol);
rolRouter.post("/", rolCtrl.createtRol);
rolRouter.put("/:id", rolCtrl.editRol);
rolRouter.delete("/:id", rolCtrl.deleteRol);
*/

Route::get('storage/{archivo}', function ($nombre) {
    $public_path = public_path();
    $url = $public_path.'/storage/'.$nombre;// depende de root en el archivo filesystems.php.
    //verificamos si el archivo existe y lo retornamos
    if (\Storage::exists($nombre))
    {
        return response()->download($url);
    }
    //si no se encuentra lanzamos un error 404.
    abort(404);
  
  });
