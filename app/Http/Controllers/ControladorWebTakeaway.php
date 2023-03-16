<?php

namespace App\Http\Controllers;

use App\Entidades\Tipo_Producto;
use App\Entidades\Producto;
use App\Entidades\Sucursal;
use App\Entidades\Carrito;
use App\Entidades\carrito;

use Illuminate\Http\Request;
require app_path() . '/start/constants.php';

use Session;

class ControladorWebTakeaway extends Controller
{
    public function index()
    {
        $categoria = new Tipo_Producto();
        $aCategorias = $categoria->obtenerTodos();

        $producto = new Producto();
        $aProductos = $producto->obtenerTodos();

        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        return view("web.takeaway", compact("aCategorias","aProductos", 'aSucursales'));
    }

    public function insertar(Request $request){
        $idCliente = Session::get("idCliente");

        $idProducto = $request->input("txtIdProducto");
        $cantidad = $request->input("txtCantidad");

        if(isset($idCliente) && $idCliente > 0){

                if(isset($cantidad) && $cantidad>0){

                    $carrito = new Carrito();
                    $carrito->fk_idcliente = $idCliente;
                    $carrito->fk_idproducto = $idProducto;
                    
                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"]= "El producto se agrego correctamnete al carrito";
                    return view("web.takeway", compact("msg"));

                }else{

                    $msg["ESTADO"] = MSG_ERROR;
                    $msg["MSG"]= "No agrego ningun producto al carrito";
                    return view("web.takeway", compact("msg"));
    
                }
        }else{
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"]= "Debes iniciar sesion para poder realizar compras";
            return view("web.takeaway", compact("msg"));
        }
    }
}