<?php 

namespace App\Http\Controllers;

use App\Entidades\Sucursal;
use App\Entidades\Cliente;
use App\Entidades\Pedido;

use Illuminate\Http\Request;

use Session;

class ControladorWebMiCuenta extends Controller{

      public function index(){
            
            $idCliente = Session::get("idCliente");
            if($idCliente != ""){

            
                  $cliente= new Cliente;
                  $cliente->obtenerPorId($idCliente);

                  $sucursal = new Sucursal();
                  $aSucursales = $sucursal->obtenerTodos();

                  $pedido = new Pedido();
                  $aPedidos = $pedido->obtenerPedidosPorCliente($idCliente);

                  return view('web.mi-cuenta', compact('cliente' ,'aSucursales', 'aPedidos'));
            }else{
                  return redirect("/login");
            }

      }

      public function guardar(Request $request){

            $idCliente = Session::get("idCliente");

            $pedido = new Pedido();
            $aPedidos = $pedido->obtenerPedidosPorCliente($idCliente);

            $cliente = new Cliente();
            $cliente->idcliente = $idCliente;
            $cliente->nombre = $request->input("txtNombre");
            $cliente->telefono = $request->input("txtTelefono");
            $cliente->correo = $request->input("txtCorreo");
            $cliente->dni = $request->input("txtDocumento");
            $cliente->direccion = $request->input("txtDireccion");
            $cliente->guardar();
            
            return view("web.mi-cuenta",compact("cliente","aPedidos"));

      }
      public function logout(){
            Session::put("idCliente","");
            return redirect("/");
      }

}


?>