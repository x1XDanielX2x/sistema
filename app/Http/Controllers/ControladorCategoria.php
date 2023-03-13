<?php 

namespace App\Http\Controllers;
use App\Entidades\Tipo_Producto;
use Illuminate\http\Request;
require app_path() . '/start/constants.php';

class ControladorCategoria extends Controller{

      public function index(){
            $titulo = "Listado de categorias";
            return view("sistema.categoria-listado", compact("titulo"));
        }
    
        public function cargarGrilla(){
            $request = $_REQUEST;
    
            $categoria = new Tipo_Producto();
            $aCategorias = $categoria->obtenerFiltrado();
    
            $data = array();
            $cont = 0;
    
            $inicio = $request['start'];
            $registros_por_pagina = $request['length'];
    
    
            for ($i = $inicio; $i < count($aCategorias) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/admin/categoria/' . $aCategorias[$i]->idtipoproducto . '">' . $aCategorias[$i]->nombre . '</a>';
                $cont++;
                $data[] = $row;
            }
    
            $json_data = array(
                "draw" => intval($request['draw']),
                "recordsTotal" => count($aCategorias), //cantidad total de registros sin paginar
                "recordsFiltered" => count($aCategorias), //cantidad total de registros en la paginacion
                "data" => $data,
            );
            return json_encode($json_data);
        }

        public function editar($idTipoProducto){

            $titulo = "Edicion categoria";
            $categoria=new Tipo_Producto();
            $categoria->obtenerPorId($idTipoProducto);
            
            return view('sistema.categoria-nuevo', compact('titulo', 'categoria'));
        }
    
          public function nuevo(){
    
                $titulo = "Nueva Categoria";
                $categoria=new Tipo_Producto();
                return view('sistema.categoria-nuevo', compact("titulo","categoria"));
          }
    
          public function guardar(Request $request){
            try{
                $titulo = "Modificar Categoria";
                $nuevaCategoria=new Tipo_Producto();
                $nuevaCategoria->cargarFormulario($request);
                if($nuevaCategoria->nombre == ""){
                    $msg["ESTADO"] = MSG_ERROR;
                    $msg["MSG"] = "Complete todos los datos";
                }else{
                    if($_POST["id"] > 0 ){
                        $nuevaCategoria->guardar();
                        $msg["ESTADO"] = MSG_SUCCESS;
                        $msg["MSG"] = OKINSERT;
                    }else{
                        $nuevaCategoria->insertar();
                        $msg["ESTADO"] = MSG_SUCCESS;
                        $msg["MSG"] = OKINSERT;
                    }
                    $_POST["id"] = $nuevaCategoria->idtipoproducto;
                    return view('sistema.categoria-listado', compact('titulo','msg'));
                }
            } catch (Exception $e) {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = ERRORINSERT;
            }
            
            $id = $nuevaCategoria->idtipoproducto;
            $categoria = new Tipo_Producto();
            $categoria->obtenerPorId($id);
    
            return view('sistema.categoria-nuevo', compact('msg', 'categoria', 'titulo')) .'?id='. $categoria->idtipoproducto;
        }

        public function eliminar(Request $request){
            $idCategoria = $_REQUEST["id"];

                //logica eliminar
                $categoria = new Tipo_Producto();
    
                $categoria->idtipoproducto=$idCategoria;
                $categoria->eliminar();
                $resultado["err"] = EXIT_SUCCESS;
                $resultado["mensaje"] = "Registro eliminado exitosamente";

            
            return json_encode($resultado);
        }

}
