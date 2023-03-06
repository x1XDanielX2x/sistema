<?php 

namespace App\Http\Controllers;
use App\Entidades\Proveedor;
use Illuminate\http\Request;
require app_path() . '/start/constants.php';


class ControladorProveedor extends Controller{

      public function index(){
            $titulo = "Listado de Proveedores";
            return view("sistema.proveedor-listado", compact("titulo"));
        }
    
        public function cargarGrilla(){
            $request = $_REQUEST;
    
            $proveedor = new Proveedor();
            $aProveedores = $proveedor->obtenerFiltrado();
    
            $data = array();
            $cont = 0;
    
            $inicio = $request['start'];
            $registros_por_pagina = $request['length'];
    
    
            for ($i = $inicio; $i < count($aProveedores) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/admin/proveedores/' . $aProveedores[$i]->idproveedor . '">' . $aProveedores[$i]->nombre . '</a>';
                $row[] = $aProveedores[$i]->direccion;
                $row[] = $aProveedores[$i]->nit;
                $row[] = $aProveedores[$i]->fk_idrubro;
                $cont++;
                $data[] = $row;
            }
    
            $json_data = array(
                "draw" => intval($request['draw']),
                "recordsTotal" => count($aProveedores), //cantidad total de registros sin paginar
                "recordsFiltered" => count($aProveedores), //cantidad total de registros en la paginacion
                "data" => $data,
            );
            return json_encode($json_data);
        }
    
          public function Nuevo(){
    
                $titulo = "Nuevo Proveedor"; 
                return view('sistema.proveedor-nuevo', compact("titulo"));
          }
    
          public function guardar(Request $request){
            
            
                try{
        
                    $titulo = "Modificar Proveedor";
                    $proveedor=new Proveedor();
                    $proveedor->cargarFormulario($request);
        
                    if($proveedor->nombre == "" || $proveedor->direccion == "" || $proveedor->nit == "" || $proveedor->fk_idrubro == ""){
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "Complete todos los datos";
                    }else{
                        if($_POST["id"] > 0 ){
                            $proveedor->guardar();
                            $msg["ESTADO"] = MSG_SUCCESS;
                            $msg["MSG"] = OKINSERT;
                        }else{
                            $proveedor->insertar();
                            $msg["ESTADO"] = MSG_SUCCESS;
                            $msg["MSG"] = OKINSERT;
                        }
                        $_POST["id"] = $proveedor->idproveedor;
                        return view('sistema.proveedor-listado', compact('titulo','msg'));
                    }
                } catch (Exception $e) {
                    $msg["ESTADO"] = MSG_ERROR;
                    $msg["MSG"] = ERRORINSERT;
                }
                $id = $proveedor->idproveedor;
                $proveedor = new Proveedor();
                $proveedor->obtenerPorId($id);
        
                return view('sistema.proveedor-nuevo', compact('msg', 'proveedor', 'titulo')) .'?id='. $proveedor->idproveedor;
            }

}
?>