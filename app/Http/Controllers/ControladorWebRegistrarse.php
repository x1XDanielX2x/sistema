<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;
require app_path() . '/start/constants.php';
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Session;

class ControladorWebRegistrarse extends Controller
{
    public function index()
    {
        return view("web.registrarse");
    }

    public function registrarse(Request $request)
    {
        $titulo = "Nuevo Registro";

        $entidad = new Cliente();
        $entidad->nombre = $request->input("txtNombre");
        $entidad->clave = password_hash($request->input("txtClave"), PASSWORD_DEFAULT);
        $entidad->dni = $request->input("txtDni");
        $entidad->direccion = $request->input("txtDireccion");
        $entidad->telefono = $request->input("txtTelefono");
        $entidad->correo = $request->input("txtCorreo");


        if ($entidad->nombre == "" || $entidad->telefono == "" || $entidad->direccion == "" || $entidad->dni == "" || $entidad->correo == "" || $entidad->clave == "") {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = "Complete todos los datos";
        } else {
            $entidad->guardar();
            $msg["ESTADO"] = MSG_SUCCESS;
            $msg["MSG"] = "Registro exitoso";
        }
        return view("web.registrarse", compact('titulo', 'msg'));
    }
}
