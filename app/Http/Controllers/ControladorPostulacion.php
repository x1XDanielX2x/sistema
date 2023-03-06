<?php 

namespace App\Http\Controllers;

class ControladorPostulacion extends Controller{

      public function Nuevo(){
            $titulo = "Nueva postulacion";
            return view('sistema.postulacion-nuevo', compact("titulo"));
      }

}
?>