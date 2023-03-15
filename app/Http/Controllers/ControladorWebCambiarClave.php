<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControladorWebCambiarClave extends Controller{

      public function index(){
            return view('web.cambiar-clave');
      }

      public function guardar(Request $request){
            
      }

}



?>