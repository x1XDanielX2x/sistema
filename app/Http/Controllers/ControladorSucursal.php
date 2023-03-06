<?php 

namespace App\Http\Controllers;
use App\Entidades\Sucursal;
use Illuminate\http\Request;
require app_path() . '/start/constants.php';


class ControladorSucursal extends Controller{

      public function index(){
            $titulo = "Listado de Sucursales";
            return view("sistema.sucursal-listado", compact("titulo"));
        }
    
        public function cargarGrilla(){
            $request = $_REQUEST;
    
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerFiltrado();
    
            $data = array();
            $cont = 0;
    
            $inicio = $request['start'];
            $registros_por_pagina = $request['length'];
    
    
            for ($i = $inicio; $i < count($aSucursales) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/admin/sucursales/' . $aSucursales[$i]->idsucursal . '">' . $aSucursales[$i]->nombre . '</a>';
                $row[] = $aSucursales[$i]->direccion;
                $row[] = $aSucursales[$i]->telefono;
                $row[] = $aSucursales[$i]->horario;
                $cont++;
                $data[] = $row;
            }
    
            $json_data = array(
                "draw" => intval($request['draw']),
                "recordsTotal" => count($aSucursales), //cantidad total de registros sin paginar
                "recordsFiltered" => count($aSucursales), //cantidad total de registros en la paginacion
                "data" => $data,
            );
            return json_encode($json_data);
        }

        public function Nuevo(){

            $titulo = "Nueva Sucursal";


            return view('sistema.sucursal-nuevo', compact("titulo", "aCategorias"));
      }

      public function guardar(Request $request){
        
        
            try{
    
                $titulo = "Modificar producto";
                $sucursal=new Sucursal();
                $sucursal->cargarFormulario($request);
    
                if($sucursal->nombre == "" || $sucursal->direccion == "" || $sucursal->telefono == "" || $sucursal->mapa == "" || $sucursal->horario == ""){
                    $msg["ESTADO"] = MSG_ERROR;
                    $msg["MSG"] = "Complete todos los datos";
                }else{
                    if($_POST["id"] > 0 ){
                        $sucursal->guardar();
                        $msg["ESTADO"] = MSG_SUCCESS;
                        $msg["MSG"] = OKINSERT;
                    }else{
                        $sucursal->insertar();
                        $msg["ESTADO"] = MSG_SUCCESS;
                        $msg["MSG"] = OKINSERT;
                    }
                    $_POST["id"] = $sucursal->idsucursal;
                    return view('sistema.sucursal-listado', compact('titulo','msg'));
                }
            } catch (Exception $e) {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = ERRORINSERT;
            }
            $id = $sucursal->idsucrusal;
            $sucursal = new Sucursal();
            $sucursal->obtenerPorId($id);
    
            return view('sistema.sucursal-nuevo', compact('msg', 'sucursal', 'titulo')) .'?id='. $sucursal->idsucursal;
        }


}
?>