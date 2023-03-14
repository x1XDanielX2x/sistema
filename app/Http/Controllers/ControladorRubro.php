<?php 

namespace App\Http\Controllers;
use App\Entidades\Rubro;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\http\Request;
require app_path() . '/start/constants.php';


class ControladorRubro extends Controller{

      public function index(){
            $titulo = "Listado de rubros";
            if (Usuario::autenticado() == true) {
                if (!Patente::autorizarOperacion("PRODUCTOCONSULTA")) {
                    $codigo = "PRODUCTOCONSULTA";
                    $mensaje = "No tiene permisos para la operación.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                    return view("sistema.rubro-listado", compact("titulo"));
                }
            } else {
                return redirect('admin/login');
            }
            
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
                $row[] = '<a href="/admin/rubro/' . $aRubros[$i]->idrublo . '">' . $aRubros[$i]->nombre . '</a>';
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

        public function editar($idRublo){

            $titulo = "Edicion cliente";
            $rubro=new Rubro();
            $rubro->obtenerPorId($idRublo);
            
            return view('sistema.rubro-nuevo', compact('titulo', 'rubro'));
        }
    
          public function Nuevo(){
    
                $titulo = "Nuevo rubro"; 
                $rubro = new Rubro();
                return view('sistema.rubro-nuevo', compact("titulo",'rubro'));
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
                        }else{exit;
                            $rubro->insertar();
                            $msg["ESTADO"] = MSG_SUCCESS;
                            $msg["MSG"] = OKINSERT;
                        }
                        $_POST["id"] = $rubro->idrublo;
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
            public function eliminar(Request $request){
                $idRubro = $_REQUEST["id"];
                    
                    //logica eliminar
                    $rubro = new Rubro();
        
                    $rubro->idrublo=$idRubro;
                    $rubro->eliminar();
                    $resultado["err"] = EXIT_SUCCESS;
                    $resultado["mensaje"] = "Registro eliminado exitosamente";
                
                return json_encode($resultado);
            }

}
?>