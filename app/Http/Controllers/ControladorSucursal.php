<?php 

namespace App\Http\Controllers;
use App\Entidades\Pedido;
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
                $row[] = '<a href="/admin/sucursal/' . $aSucursales[$i]->idsucursal . '">' . $aSucursales[$i]->nombre . '</a>';
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

        public function editar($idSucursal){

            $titulo = "Edicion sucursal";
            $sucursal=new Sucursal();
            $sucursal->obtenerPorId($idSucursal);
            
            return view('sistema.sucursal-nuevo', compact('titulo', 'sucursal'));
        }

        public function Nuevo(){

            $titulo = "Nueva Sucursal";
            $sucursal = new Sucursal();
            return view('sistema.sucursal-nuevo', compact("titulo", "sucursal"));
      }

      public function guardar(Request $request){
        
            try{
    
                $titulo = "Modificar producto";
                $sucursal=new Sucursal();
                $sucursal->cargarFormulario($request);
    
                if($sucursal->nombre == ""){
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

        public function eliminar(Request $request){
            $idSucursal = $_REQUEST["id"];
            $pedido = new Pedido();

            if($pedido->obtenerPedidosPorSucursal($idSucursal)){
                $resultado["err"] = EXIT_FAILURE;
                $resultado["mensaje"]="No se puede eliminar una sucursal con pedidos asociados.";

            }else{
                //logica eliminar
                $sucursal = new Sucursal();
    
                $sucursal->idsucursal=$idSucursal;
                $sucursal->eliminar();
                $resultado["err"] = EXIT_SUCCESS;
                $resultado["mensaje"] = "Registro eliminado exitosamente";
            
            }
            return json_encode($resultado); 
        }


}
?>