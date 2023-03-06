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
                $row[] = '<a href="/admin/categorias/' . $aCategorias[$i]->idtipoproducto . '">' . $aCategorias[$i]->nombre . '</a>';
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
    
          public function Nuevo(){
    
                $titulo = "Nueva Categoria"; 
                return view('sistema.categoria-nuevo', compact("titulo"));
          }
    
          public function guardar(Request $request){
            
            
                try{
        
                    $titulo = "Modificar Categoria";
                    $categoria=new Tipo_Producto();
                    $categoria->cargarFormulario($request);
        
                    if($categoria->nombre == ""){
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "Complete todos los datos";
                    }else{
                        if($_POST["id"] > 0 ){
                            $categoria->guardar();
                            $msg["ESTADO"] = MSG_SUCCESS;
                            $msg["MSG"] = OKINSERT;
                        }else{
                            $categoria->insertar();
                            $msg["ESTADO"] = MSG_SUCCESS;
                            $msg["MSG"] = OKINSERT;
                        }
                        $_POST["id"] = $categoria->idcategoria;
                        return view('sistema.postulacion-listado', compact('titulo','msg'));
                    }
                } catch (Exception $e) {
                    $msg["ESTADO"] = MSG_ERROR;
                    $msg["MSG"] = ERRORINSERT;
                }
                $id = $categoria->idcategoria;
                $categoria = new Tipo_Producto();
                $categoria->obtenerPorId($id);
        
                return view('sistema.categoria-nuevo', compact('msg', 'categoria', 'titulo')) .'?id='. $categoria->idcategoria;
            }

}
?>