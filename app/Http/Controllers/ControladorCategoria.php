<?php 

namespace App\Http\Controllers;

class ControladorCategoria extends Controller{

      public function nuevo(){
            $titulo = "Nueva Categoria";
            return view('sistema.tipoproducto-nuevo', compact("titulo"));
      }

}
?>