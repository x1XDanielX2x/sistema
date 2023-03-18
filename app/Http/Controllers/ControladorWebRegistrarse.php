<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

use Session;

class ControladorWebRegistrarse extends Controller
{
    public function index()
    {
        return view("web.registrarse");
    }

    public function registrarse(Request $request)
    {

        $entidad = new Cliente();
        $entidad->nombre = $request->input("txtNombre");
        $entidad->clave = password_hash($request->input("txtClave"), PASSWORD_DEFAULT);
        $entidad->dni = $request->input("txtDni");
        $entidad->direccion = $request->input("txtDireccion");
        $entidad->telefono = $request->input("txtTelefono");
        $entidad->correo = $request->input("txtCorreo");

        $sucursal=new Sucursal();
        $aSucursales =$sucursal->obtenerTodos();

        if ($entidad->nombre == "" || $entidad->telefono == "" || $entidad->direccion == "" || $entidad->dni == "" || $entidad->correo == "" || $entidad->clave == "") {

            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = "Complete todos los datos";
            return view("web.registrarse", compact('msg', 'aSucursales'));
        } else {
            $entidad->insertar();
            return redirect("/login");
        }
        
    }
}
