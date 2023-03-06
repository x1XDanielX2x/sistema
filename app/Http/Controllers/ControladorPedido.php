<?php 

namespace App\Http\Controllers;

class ControladorPedido extends Controller{

      public function Nuevo(){
            $titulo = "Nuevo Pedido";
            return view('sistema.pedido-nuevo', compact("titulo"));
      }

}
?>