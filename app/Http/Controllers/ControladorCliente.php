<?php 

namespace App\Http\Controllers;
use App\Entidades\Cliente;
use Illuminate\Http\Request;
require app_path() . '/start/constants.php';

class ControladorCliente extends Controller{

    public function nuevo(){
        $titulo = 'Nuevo cliente';
        return view("sistema.cliente-nuevo", compact("titulo"));//en vez de colocar el '/' para el directorio, se coloca '.'... No se coloca la extension, ya que laravel sabe que es '.blade.php' automaticamente
    } //Tampoco se coloca todo el directorio, ya que laravel sabe a que ruta debe dirigirse (resource/views)

    public function guardar(Request $request){
        
        
        try{

            $titulo = "Modificar cliente";
            $cliente=new Cliente();
            $cliente->cargarFormulario($request);

            if($cliente->nombre == "" || $cliente->telefono == "" || $cliente->direccion == "" || $cliente->dni == "" || $cliente->correo == "" || $cliente->clave == ""){
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            }else{
                if($_POST["id"] > 0 ){
                    $cliente->guardar();
                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }else{
                    $cliente->insertar();
                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }
                $_POST["id"] = $cliente->idcliente;
                return view('sistema.cliente-listado', compact('titulo','msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
        $id = $cliente->idcliente;
        $cliente = new Cliente();
        $cliente->obtenerPorId($id);

        return view('sistema.cliente-nuevo', compact('msg', 'cliente', 'titulo')) .'?id='. $cliente->idcliente;
    }
}
?>