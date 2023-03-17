<?php

namespace App\Http\Controllers;

use App\Entidades\Carrito;
use App\Entidades\Producto;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;
use Session;
require app_path() . '/start/constants.php';

class ControladorWebCarrito extends Controller
{
    public function index()
    {
        $idCliente=Session::get("idCliente");

        $carrito = new Carrito();
        $aCarritos = $carrito->obtenerPorCliente($idCliente);

        $sucursal=new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        return view("web.carrito", compact("aSucursales", "aCarritos"));
    }

    public function guardar(Request $request)
    {
        $titulo = "Nueva Orden";

        $entidad = new Carrito();
        $entidad->cargarFormulario($request);

        
    }
}
?>