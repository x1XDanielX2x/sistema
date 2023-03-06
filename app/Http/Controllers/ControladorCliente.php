<?php 

namespace App\Http\Controllers;

class ControladorCliente extends Controller{

    public function nuevo(){
        $titulo = 'Nuevo cliente';
        return view("sistema.cliente-nuevo", compact("titulo"));//en vez de colocar el '/' para el directorio, se coloca '.'... No se coloca la extension, ya que laravel sabe que es '.blade.php' automaticamente
    } //Tampoco se coloca todo el directorio, ya que laravel sabe a que ruta debe dirigirse (resource/views)

}
?>