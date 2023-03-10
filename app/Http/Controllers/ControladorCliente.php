<?php 

namespace App\Http\Controllers;
use App\Entidades\Cliente;
use App\Entidades\Pedido;
use Illuminate\Http\Request;
require app_path() . '/start/constants.php';

class ControladorCliente extends Controller{

    public function index(){
        $titulo = "Listado de clientes";
        return view("sistema.cliente-listado", compact("titulo"));
    }

    public function cargarGrilla(){
        $request = $_REQUEST;

        $cliente = new Cliente();
        $aClientes = $cliente->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aClientes) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/cliente/' . $aClientes[$i]->idcliente . '">' . $aClientes[$i]->nombre . '</a>';
            $row[] = $aClientes[$i]->telefono;
            $row[] = $aClientes[$i]->dni;
            $row[] = $aClientes[$i]->correo;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aClientes), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aClientes), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

    public function editar($idCliente){

        $titulo = "Edicion cliente";
        $cliente=new Cliente();
        $cliente->obtenerPorId($idCliente);
        
        return view('sistema.cliente-nuevo', compact('titulo', 'cliente'));
    }

    public function nuevo(){
        $titulo = 'Nuevo cliente';
        $cliente =new Cliente();
        return view("sistema.cliente-nuevo", compact("titulo",'cliente'));//en vez de colocar el '/' para el directorio, se coloca '.'... No se coloca la extension, ya que laravel sabe que es '.blade.php' automaticamente
    } //Tampoco se coloca todo el directorio, ya que laravel sabe a que ruta debe dirigirse (resource/views)

    public function guardar(Request $request){
        try{
            $titulo = "Modificar cliente";
            $clientenuevo=new Cliente();
            $clientenuevo->cargarFormulario($request);

            if($clientenuevo->nombre == ""){
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            }else{
                if($_POST["id"] > 0 ){
                    $clientenuevo->guardar();
                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }else{
                    $clientenuevo->insertar();
                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }
                $_POST["id"] = $clientenuevo->idcliente;
                return view('sistema.cliente-listado', compact('titulo','msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
        
        $id = $clientenuevo->idcliente;
        $cliente = new Cliente();
        $cliente->obtenerPorId($id);

        return view('sistema.cliente-nuevo', compact('msg', 'cliente', 'titulo')) .'?id='. $cliente->idcliente;
    }

    public function eliminar(Request $request){
        $idCliente = $request->input("id");
        $pedido = new Pedido();

        //Preguntar por is hay llaves foraneas

        if($pedido->obtenerPedidosPorCliente($idCliente)){
            $resultado["err"] = EXIT_FAILURE;
            $resultado["mensaje"]="No se puede eliminar un cliente con productos asociados.";

        }else{
            //logica eliminar
            $cliente = new Cliente();

            $cliente->idcliente=$idCliente;
            $cliente->eliminar();
            $resultado["err"] = EXIT_SUCCESS;
            $resultado["mensaje"] = "Registro eliminado exitosamente";
        }
        return json_encode($resultado);
    }
}
?>