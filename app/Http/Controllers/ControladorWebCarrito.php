<?php

namespace App\Http\Controllers;

use App\Entidades\Carrito;
use Illuminate\Http\Producto;
require app_path() . '/start/constants.php';


class ControladorWebCarrito extends Controller
{
    public function index()
    {
        $idCarrito=1;
        $carrito = new Carrito();
        $aCarritos = $carrito->obtenerPorId($idCarrito);
        return view("web.carrito", compact("carrito", "aCarritos"));
    }

    public function guardar(Request $request)
    {
        $titulo = "Nueva Orden";

        $entidad = new Carrito();
        $entidad->cargarFormulario($request);

        
    }
}
