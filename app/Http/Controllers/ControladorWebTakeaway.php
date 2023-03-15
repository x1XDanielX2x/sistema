<?php

namespace App\Http\Controllers;

use App\Entidades\Tipo_Producto;
use App\Entidades\Producto;

use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;

use Session;

class ControladorWebTakeaway extends Controller
{
    public function index()
    {
        $categoria = new Tipo_Producto();
        $aCategorias = $categoria->obtenerTodos();

        $producto = new Producto();
        $aProductos = $producto->obtenerTodos();



        return view("web.takeaway", compact("aCategorias","aProductos"));
    }

    public function insertar(Request $request){
        $idCliente = Session::get("idCliente");
        $idProducto = $request->input("txtIdProducto");
        $cantidad = $request->input("txtCantidad");
    }
}