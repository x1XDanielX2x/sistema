<?php 

namespace App\Http\Controllers;

use App\Entidades\Cliente;

use Illuminate\Http\Request;

require app_path().'/start/constants.php';

use Session;

class ControladorWebCambiarClave extends Controller{

      public function index(){
            return view('web.cambiar-clave');
      }

      public function cambiar(Request $request){
            $cliente = new Cliente();
            $idCliente = Session::get("idCliente");

            $clave1 = $request->input("txtNuevaClave");
            $clave2 = $request->input("txtRepetirNuevaClave");

            if($clave1 !="" && $clave1 == $clave2){
                  $cliente->obtenerPorId($idCliente);
                  $cliente->clave = password_hash($clave1, PASSWORD_DEFAULT);
                  $cliente->guardar();
                  //mensaje para guardar falta
                  $msg["ESTADO"]=MSG_SUCCESS;
                  $msg["MSG"]="Tu contraseña se cambio correctamente";
                  return view('web.cambiar-clave', compact('msg'));
            }else{
                  $msg["ESTADO"]=MSG_ERROR;
                  $msg["MSG"]="Contraseñas no coinciden";
                  return view('web.cambiar-clave', compact('msg'));

            }
      }

}



?>