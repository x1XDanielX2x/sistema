<?php 

namespace App\Http\Controllers;

class ControladorSucursal extends Controller{

      public function Nuevo(){
            $titulo = "Nueva Sucursal";
            return view('sistema.sucursal-nuevo', compact("titulo"));
      }

}
?>