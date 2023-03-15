<?php 

namespace App\Http\Controllers;
use App\Entidades\Producto;
use Illuminate\http\Request;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Tipo_Producto;
require app_path() . '/start/constants.php';


class ControladorProducto extends Controller{

    public function index(){
        $titulo = "Listado de productos";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("PRODUCTOCONSULTA")) {
                $codigo = "PRODUCTOCONSULTA";
                $mensaje = "No tiene permisos para la operación.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view("sistema.producto-listado", compact("titulo"));
            }
        } else {
            return redirect('admin/login');
        }
        
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
            $row[] = '<a href="/admin/producto/' . $aProductos[$i]->idproducto . '">' . $aProductos[$i]->titulo . '</a>';
            $row[] = $aProductos[$i]->categoria;
            $row[] = $aProductos[$i]->cantidad;
            $row[] = number_format($aProductos[$i]->precio, 0, ',','.');
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

    public function editar($idProducto){

        $titulo = "Edicion producto";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("PRODUCTOEDITAR")) {
                $codigo = "PRODUCTOEDITAR";
                $mensaje = "No tiene permisos para la operación.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $producto=new Producto();
                $producto->obtenerPorId($idProducto);
                $categoria=new Tipo_Producto();
                $aCategorias=$categoria->obtenerTodos();
                
                return view('sistema.producto-nuevo', compact('titulo', 'producto','aCategorias'));
            }
        } else {
            return redirect('admin/login');
        }
        
    }

      public function Nuevo(){

            $titulo = "Nuevo Producto";

            $producto = new Producto();
            $categoria = new Tipo_Producto();
            $aCategorias = $categoria->obtenerTodos();

            return view('sistema.producto-nuevo', compact("titulo", "aCategorias", "producto"));
      }

      public function guardar(Request $request){
        
        
            try{
    
                $titulo = "Modificar producto";
                $producto=new Producto();
                $producto->cargarFormulario($request);
    
                if($producto->precio == "" || $producto->cantidad == "" || $producto->descripcion == "" || $producto->titulo == "" || $producto->fk_idtipoproducto == ""){

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