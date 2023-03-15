<?php

namespace App\Http\Controllers;

use App\Entidades\Carrito;
use App\Entidades\Producto;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;
require app_path() . '/start/constants.php';


class ControladorWebCarrito extends Controller
{
    public function index()
    {
        $idCarrito=1;

        $carrito = new Carrito();
        $aCarritos = $carrito->obtenerPorId($idCarrito);

        $sucursal=new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        return view("web.carrito", compact("aSucursales","carrito", "aCarritos"));
    }

    public function guardar(Request $request)
    {
        $titulo = "Nueva Orden";

        $entidad = new Carrito();
        $entidad->cargarFormulario($request);

        
    }
}
?>