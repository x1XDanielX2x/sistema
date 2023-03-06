<?php 

namespace App\Http\Controllers;
use App\Entidades\Producto;
use Illuminate\http\Request;
use App\Entidades\Tipo_Producto;
require app_path() . '/start/constants.php';


class ControladorProducto extends Controller{

    public function index(){
        $titulo = "Listado de productos";
        return view("sistema.producto-listado", compact("titulo"));
    }

    public function cargarGrilla(){
        $request = $_REQUEST;

        $producto = new Producto();
        $aProductos = $producto->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aProductos) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/productos/' . $aProductos[$i]->idproducto . '">' . $aProductos[$i]->titulo . '</a>';
            $row[] = $aProductos[$i]->fk_idtipoproducto;
            $row[] = $aProductos[$i]->cantidad;
            $row[] = $aProductos[$i]->precio;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aProductos), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aProductos), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

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
    
            return view('sistema.producto-nuevo', compact('msg', 'producto', 'titulo')) .'?id='. $producto->idproducto;
        }

}
?>