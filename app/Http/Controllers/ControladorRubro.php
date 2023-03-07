<?php 

namespace App\Http\Controllers;
use App\Entidades\Rubro;
use Illuminate\http\Request;
require app_path() . '/start/constants.php';


class ControladorRubro extends Controller{

      public function index(){
            $titulo = "Listado de rubros";
            return view("sistema.rubro-listado", compact("titulo"));
        }
    
        public function cargarGrilla(){
            $request = $_REQUEST;
    
            $rubro = new Rubro();
            $aRubros = $rubro->obtenerFiltrado();
    
            $data = array();
            $cont = 0;
    
            $inicio = $request['start'];
            $registros_por_pagina = $request['length'];
    
    
            for ($i = $inicio; $i < count($aRubros) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/admin/rubros/' . $aRubros[$i]->idrublo . '">' . $aRubros[$i]->nombre . '</a>';
                $cont++;
                $data[] = $row;
            }
    
            $json_data = array(
                "draw" => intval($request['draw']),
                "recordsTotal" => count($aRubros), //cantidad total de registros sin paginar
                "recordsFiltered" => count($aRubros), //cantidad total de registros en la paginacion
                "data" => $data,
            );
            return json_encode($json_data);
        }

        public function editar($idRubro){

            $titulo = "Edicion cliente";
            $rubro=new Rubro();
            $rubro->obtenerPorId($idRubro);
            
            return view('sistema.rubro-nuevo', compact('titulo', 'rubro'));
        }
    
          public function Nuevo(){
    
                $titulo = "Nuevo rubro"; 
                return view('sistema.rubro-nuevo', compact("titulo"));
          }
    
          public function guardar(Request $request){
            
            
                try{
        
                    $titulo = "Modificar Rubro";
                    $rubro=new Rubro();
                    $rubro->cargarFormulario($request);
        
                    if($rubro->nombre == ""){
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "Complete todos los datos";
                    }else{
                        if($_POST["id"] > 0 ){
                            $rubro->guardar();
                            $msg["ESTADO"] = MSG_SUCCESS;
                            $msg["MSG"] = OKINSERT;
                        }else{
                            $rubro->insertar();
                            $msg["ESTADO"] = MSG_SUCCESS;
                            $msg["MSG"] = OKINSERT;
                        }
                        $_POST["id"] = $rubro->idrubro;
                        return view('sistema.rubro-listado', compact('titulo','msg'));
                    }
                } catch (Exception $e) {
                    $msg["ESTADO"] = MSG_ERROR;
                    $msg["MSG"] = ERRORINSERT;
                }
                $id = $rubro->idrublo;
                $rubro = new Rubro();
                $rubro->obtenerPorId($id);
        
                return view('sistema.rubro-nuevo', compact('msg', 'rubro', 'titulo')) .'?id='. $rubro->idrublo;
            }

}
?>