<?php

namespace App\Http\Controllers;

use App\Entidades\Sucursal;
use App\Entidades\Postulacion;

use Illuminate\Http\Request;

use Session;

class ControladorWebNosotros extends Controller
{
    public function index()
    {
        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();
            return view("web.nosotros", compact('aSucursales'));
    }

    public function guardar(Request $request){

        $postulacion = new Postulacion();
        $postulacion->nombre = $request->input("txtNombre");
        $postulacion->apellido = $request->input("txtApellido");
        $postulacion->correo = $request->input("txtCorreo");
        $postulacion->telefono = $request->input("txtTelefono");
        //hoja de vida
        $postulacion->insertar();

        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        return view("web.postulacion-gracias", compact('aSucursales'));


    }
}