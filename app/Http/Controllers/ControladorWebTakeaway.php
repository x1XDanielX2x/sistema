<?php

namespace App\Http\Controllers;

use App\Entidades\Tipo_Producto;
use App\Entidades\Producto;
use App\Entidades\Sucursal;
use App\Entidades\Carrito;

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

        $categoria = new Tipo_Producto();
        $aCategorias = $categoria->obtenerTodos();

        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        $producto = new Producto();
        $aProductos = $producto->obtenerTodos();

        if($idCliente > 0){

                if(isset($cantidad) && $cantidad>0){

                    $carrito = new Carrito();
                    $carrito->fk_idcliente = $idCliente;
                    $carrito->fk_idproducto = $idProducto;
                    $carrito->cantidad = $cantidad;
                    
                    $carrito->insertar();
                    
                    $msg["ESTADO"] = "alert-success";
                    $msg["MSG"]= "El producto se agrego correctamente al carrito";
                    return view("web.takeaway", compact("msg", 'aCategorias', 'aSucursales',"aProductos"));

                }else{

                    $msg["ESTADO"] = "alert-danger";
                    $msg["MSG"]= "No agrego ningun producto al carrito";
                    return view("web.takeaway", compact("msg", 'aCategorias', 'aSucursales',"aProductos"));
    
                }
        }else{
            $msg["ESTADO"] = "alert-danger";
            $msg["MSG"]= "Debes iniciar sesion para poder realizar compras";
            return view("web.takeaway", compact("msg", 'aCategorias', 'aSucursales',"aProductos"));
        }
    }
}