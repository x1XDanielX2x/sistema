<?php 

namespace App\Http\Controllers;

use App\Entidades\Sucursal;
use App\Entidades\Cliente;

use Session;

use Illuminate\Http\Request;


class ControladorWebLogin extends Controller{

      public function index(Request $request){

            $titulo = "Ingresar al sistema";
            
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();

            return view('web.login', compact('titulo' ,'aSucursales'));

      }

      public function ingresar(Request $request){

            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();
            $correo = $_REQUEST["txtCorreo"];
            $clave = $_REQUEST["txtClave"];
           
            $cliente = new Cliente();
            $cliente->obtenerPorCorreo($correo);
            if($cliente->correo !=""){
                  if(password_verify($clave, $cliente->clave)){
                        Session::put("idCliente",$cliente->idcliente);
                        return view('web.index', compact('aSucursales'));
                  }else{
                        $mensaje = "Credenciales incorrectas";
                        return view('web.login', compact('mensaje','aSucursales'));
                  }
            }

      }
      public function logout(){
            Session::put("idCliente","");
            return redirect("/");
      }

}


?>