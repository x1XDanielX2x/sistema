<?php 

namespace App\Http\Controllers;

class ControladorRubro extends Controller{

      public function Nuevo(){
            $titulo = "Nuevo Rubro";
            return view('sistema.rubro-nuevo', compact("titulo"));
      }

}
?>