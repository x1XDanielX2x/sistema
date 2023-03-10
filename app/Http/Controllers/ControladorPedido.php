<?php 

namespace App\Http\Controllers;
use App\Entidades\Pedido;
use App\Entidades\Cliente;
use App\Entidades\Sucursal;
use App\Entidades\Estado_Pedido;
use Illuminate\http\Request;
require app_path() . '/start/constants.php';


class ControladorPedido extends Controller{

      public function index(){
            $titulo = "Listado de Pedidos";
            return view("sistema.pedido-listado", compact("titulo"));
        }
    
        public function cargarGrilla(){
            $request = $_REQUEST;
    
            $pedido = new Pedido();
            $aPedidos = $pedido->obtenerFiltrado();
    
            $data = array();
            $cont = 0;
    
            $inicio = $request['start'];
            $registros_por_pagina = $request['length'];
    
    
            for ($i = $inicio; $i < count($aPedidos) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/admin/pedido/' . $aPedidos[$i]->idpedido . '">' . $aPedidos[$i]->fk_idsucursal . '</a>';
                $row[] = $aPedidos[$i]->fk_idestadopedido;
                $row[] = $aPedidos[$i]->fecha;
                $row[] = $aPedidos[$i]->total;
                $cont++;
                $data[] = $row;
            }
    
            $json_data = array(
                "draw" => intval($request['draw']),
                "recordsTotal" => count($aPedidos), //cantidad total de registros sin paginar
                "recordsFiltered" => count($aPedidos), //cantidad total de registros en la paginacion
                "data" => $data,
            );
            return json_encode($json_data);
        }

        public function editar($idPedido){

            $titulo = "Edicion pedido";
            $pedido=new Pedido();
            $pedido->obtenerPorId($idPedido);

            $cliente = new Cliente();
            $cliente->obtenerPorId($idPedido);

            $sucursal = new Sucursal();
            $sucursal->obtenerPorId($idPedido);

            $estadopedido = new Estado_Pedido();
            $estadopedido->obtenerPorId($idPedido);
            
            return view('sistema.pedido-nuevo', compact('titulo', 'pedido', 'cliente'. 'sucursal'. 'estadopedido'));
        }
    
          public function Nuevo(){
    
                $titulo = "Nuevo Pedido"; 

                $cliente = new Cliente();
                $aClientes = $cliente->obtenerTodos();

                $sucursal = new Sucursal();
                $aSucursales = $sucursal->obtenerTodos();

                $estadopedido = new Estado_Pedido();
                $aEstadoPedidos = $estadopedido->obtenerTodos();

                return view('sistema.pedido-nuevo', compact("titulo", "aClientes","aSucursales", "aEstadoPedidos"));
          }
    
          public function guardar(Request $request){
            
            
                try{
        
                    $titulo = "Modificar Pedido";
                    $pedido=new Pedido();
                    $pedido->cargarFormulario($request);
        
                    if($pedido->fk_idcliente == "" || $pedido->fk_idsucursal == "" || $pedido->fk_idestadopedido == "" || $pedido->fecha == "" || $pedido->total == ""){
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "Complete todos los datos";
                    }else{
                        if($_POST["id"] > 0 ){
                            $pedido->guardar();
                            $msg["ESTADO"] = MSG_SUCCESS;
                            $msg["MSG"] = OKINSERT;
                        }else{
                            $pedido->insertar();
                            $msg["ESTADO"] = MSG_SUCCESS;
                            $msg["MSG"] = OKINSERT;
                        }
                        $_POST["id"] = $pedido->idpedido;
                        return view('sistema.pedido-listado', compact('titulo','msg'));
                    }
                } catch (Exception $e) {
                    $msg["ESTADO"] = MSG_ERROR;
                    $msg["MSG"] = ERRORINSERT;
                }
                $id = $pedido->idpedido;
                $pedido = new Pedido();
                $pedido->obtenerPorId($id);
        
                return view('sistema.pedido-nuevo', compact('msg', 'pedido', 'titulo')) .'?id='. $pedido->idpedido;
            }

}
?>