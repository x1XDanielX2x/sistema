<?php 

namespace App\Http\Controllers;
use App\Entidades\Postulacion;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\http\Request;
require app_path() . '/start/constants.php';


class ControladorPostulacion extends Controller{

      public function index(){
            $titulo = "Listado de postulaciones";
            if (Usuario::autenticado() == true) {
                if (!Patente::autorizarOperacion("POSTULANTECONSULTA")) {
                    $codigo = "POSTULANTECONSULTA";
                    $mensaje = "No tiene permisos para la operación.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                    return view("sistema.postulacion-listado", compact("titulo"));
                }
            } else {
                return redirect('admin/login');
            }
        }
    
        public function cargarGrilla(){
            $request = $_REQUEST;
    
            $postulacion = new Postulacion();
            $aPostulaciones = $postulacion->obtenerFiltrado();
    
            $data = array();
            $cont = 0;
    
            $inicio = $request['start'];
            $registros_por_pagina = $request['length'];
    
    
            for ($i = $inicio; $i < count($aPostulaciones) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/admin/postulacion/' . $aPostulaciones[$i]->idpostulacion . '">' . $aPostulaciones[$i]->nombre . '</a>';
                $row[] = $aPostulaciones[$i]->apellido;
                $row[] = $aPostulaciones[$i]->telefono;
                $row[] = $aPostulaciones[$i]->correo;
                $row[] = '<a href= "/files/' . $aPostulaciones[$i]->cv . '">Descargar</a>';
                $cont++;
                $data[] = $row;
            }
    
            $json_data = array(
                "draw" => intval($request['draw']),
                "recordsTotal" => count($aPostulaciones), //cantidad total de registros sin paginar
                "recordsFiltered" => count($aPostulaciones), //cantidad total de registros en la paginacion
                "data" => $data,
            );
            return json_encode($json_data);
        }

        public function editar($idPostulacion){

            $titulo = "Edicion postulacion";
            if (Usuario::autenticado() == true) {
                if (!Patente::autorizarOperacion("POSTULANTEEDITAR")) {
                    $codigo = "POSTULANTEEDITAR";
                    $mensaje = "No tiene permisos para la operación.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                    $postulacion=new Postulacion();
                    $postulacion->obtenerPorId($idPostulacion);
                    
                    return view('sistema.postulacion-nuevo', compact('titulo', 'postulacion'));
                }
            } else {
                return redirect('admin/login');
            }
            
        }
    
          public function Nuevo(){
    
                $titulo = "Nueva Postulacion"; 
                $postulacion=new Postulacion();
                return view('sistema.postulacion-nuevo', compact("titulo", 'postulacion'));
          }
    
          public function guardar(Request $request){
            
                try{
        
                    $titulo = "Modificar Postulacion";
                    $postulacion=new Postulacion();
                    $postulacion->cargarFormulario($request);
        
                    if($postulacion->nombre == "" || $postulacion->apellido == "" || $postulacion->telefono == "" || $postulacion->correo == "" || $postulacion->cv == ""){
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "Complete todos los datos";
                    }else{
                        if($_POST["id"] > 0 ){
                            $postulacion->guardar();
                            $msg["ESTADO"] = MSG_SUCCESS;
                            $msg["MSG"] = OKINSERT;
                        }else{
                            $postulacion->insertar();
                            $msg["ESTADO"] = MSG_SUCCESS;
                            $msg["MSG"] = OKINSERT;
                        }
                        $_POST["id"] = $postulacion->idpostulacion;
                        return view('sistema.postulacion-listado', compact('titulo','msg'));
                    }
                } catch (Exception $e) {
                    $msg["ESTADO"] = MSG_ERROR;
                    $msg["MSG"] = ERRORINSERT;
                }
                $id = $postulacion->idproducto;
                $postulacion = new Postulacion();
                $postulacion->obtenerPorId($id);
        
                return view('sistema.postulacion-nuevo', compact('msg', 'postulacion', 'titulo')) .'?id='. $postulacion->idpostulacion;
            }
            public function eliminar(Request $request){
                $idPostulacion = $_REQUEST['id'];        
            
                    //logica eliminar
                    $postulacion = new Postulacion();
        
                    $postulacion->idpostulacion=$idPostulacion;
                    $postulacion->eliminar();
                    $resultado["err"] = EXIT_SUCCESS;
                    $resultado["mensaje"] = "Registro eliminado exitosamente";
                
                return json_encode($resultado);
            }
}
?>