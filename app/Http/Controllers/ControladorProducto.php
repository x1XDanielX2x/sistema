<?php 

namespace App\Http\Controllers;
use App\Entidades\Producto;
use Illuminate\http\Request;
use App\Entidades\Tipo_Producto;
require app_path() . '/start/constants.php';


class ControladorProducto extends Controller{

      public function Nuevo(){

            $titulo = "Nuevo Producto";

            $categoria = new Tipo_Producto();
            $aCategorias = $categoria->obtenerTodos();

            return view('sistema.producto-nuevo', compact("titulo", "aCategorias"));
      }

      public function guardar(Request $request){
        
        
            try{
    
                $titulo = "Modificar producto";
                $producto=new Producto();
                $producto->cargarFormulario($request);
    
                if($producto->precio == "" || $producto->cantidad == "" || $producto->descripcion == "" || $producto->titulo == "" || $producto->imagen == "" || $producto->fk_idTipoProducto == ""){
                    $msg["ESTADO"] = MSG_ERROR;
                    $msg["MSG"] = "Complete todos los datos";
                }else{
                    if($_POST["id"] > 0 ){
                        $producto->guardar();
                        $msg["ESTADO"] = MSG_SUCCESS;
                        $msg["MSG"] = OKINSERT;
                    }else{
                        $producto->insertar();
                        $msg["ESTADO"] = MSG_SUCCESS;
                        $msg["MSG"] = OKINSERT;
                    }
                    $_POST["id"] = $producto->idproducto;
                    return view('sistema.producto-listado', compact('titulo','msg'));
                }
            } catch (Exception $e) {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = ERRORINSERT;
            }
            $id = $producto->idproducto;
            $producto = new Producto();
            $producto->obtenerPorId($id);
    
            return view('sistema.producto-nuevo', compact('msg', 'cliente', 'titulo')) .'?id='. $producto->idproducto;
        }

}
?>