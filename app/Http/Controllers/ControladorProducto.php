<?php 

namespace App\Http\Controllers;

class ControladorProducto extends Controller{

      public function Nuevo(){
            $titulo = "Nuevo Producto";
            return view('sistema.producto-nuevo', compact("titulo"));
      }

}
?>