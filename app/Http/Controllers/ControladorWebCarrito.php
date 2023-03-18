<?php

namespace App\Http\Controllers;

use App\Entidades\Carrito;
use App\Entidades\Cliente;
use App\Entidades\Pedido_producto;
use App\Entidades\Sucursal;
use App\Entidades\Pedido;

use MercadoPago\Item;
use MercadoPago\MerchantOrder;
use MercadoPago\Payer;
use MercadoPago\Payment;
use MercadoPago\Preference;
use MercadoPago\SDK;

use Illuminate\Http\Request;

use Session;
require app_path() . '/start/constants.php';

class ControladorWebCarrito extends Controller
{
    public function index()
    {
        $idCliente=Session::get("idCliente");

        $carrito = new Carrito();
        $aCarritos = $carrito->obtenerPorCliente($idCliente);

        $sucursal=new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        return view("web.carrito", compact("aSucursales", "aCarritos"));
    }

    public function guardar(Request $request)
    {
        $titulo = "Nueva Orden";

        $entidad = new Carrito();
        $entidad->cargarFormulario($request);

    }

    public function procesar(Request $request){

        if(isset($_POST["btnEliminar"])){
            return $this->eliminar($request);
        }
        else if(isset($_POST["btnActualizar"])){
            return $this->actualizar($request);
        }
        else if(isset($_POST["btnFinalizar"])){
            return $this->insertarPedido($request);
        }
    }

    public function actualizar(Request $request){
        
        
        $carrito = new Carrito;
        
        $idCliente = Session::get("idCliente");
        
        $cantidad = $request->input("txtCantidad");
        $idCarrito = $request->input("txtIdCarrito");
        $idProducto = $request->input("txtProducto");
        
        $carrito->cantidad=$cantidad;
        $carrito->fk_idcliente = $idCliente;
        $carrito->fk_idproducto = $idProducto;
        $carrito->idcarrito = $idCarrito;
        $carrito->guardar();
        
        $resultado["err"]= EXIT_SUCCESS;
        $resultado["mensaje"]="Producto actualizado exitosamente.";

        $aCarritos = $carrito->obtenerPorCliente($idCliente);

        return view("web.carrito","resultado",'aCarritos');
    }

    public function eliminar(Request $request){
        
        $idCliente = Session::get("idCliente");

        $idCarrito = $request->input("txtIdCarrito");

        $carrito = new Carrito();
        $aCarritos=$carrito->obtenerPorCliente($idCliente);
        $sucursal=new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        $carrito->idcarrito = $idCarrito;
        $carrito->eliminar();

        $resultado["err"]= EXIT_SUCCESS;
        $resultado["mensaje"]="Producto eliminado exitosamente.";
        
        return view("web.carrito", compact("resultado",'aCarritos'));
    }

    public function insertarPedido(Request $request){

        $idCliente = Session::get("idCliente");

        $pedidoSucursal = $request->input("lstSucursal");
        $pago=$request->input("lstMetodoPago");
        $fecha = date("Y-m-d");//Al insertar la fecha en base de datos, se debe ingresar con el orden de base de datos (Y-m-d)
        
        if($pago == "MercadoPago"){
            $this->procesarMercadoPago($request);
        }else{

        $carrito= new Carrito();
        $aCarritos=$carrito->obtenerPorCliente($idCliente);

        $sucursal=new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        $total=0;

        foreach($aCarritos as $item){
            $total += $item->cantidad * $item->precio;
        }
        
        

        $pedido = new Pedido();
        $pedido->fk_idsucursal=$pedidoSucursal;
        $pedido->fk_idcliente=$idCliente;
        $pedido->fk_idestadopedido=1;
        $pedido->fecha = $fecha;
        $pedido->total=$total;
        $pedido->pago = $pago;
        $pedido->insertar();

        $pedidoProducto = new Pedido_producto();
        foreach($aCarritos as $item){

            $pedidoProducto->fk_idproducto = $item->fk_idproducto;
            $pedidoProducto->fk_idpedido = $pedido->idpedido;
            $pedidoProducto->cantidad = $item->cantidad;
            $pedidoProducto->insertar();
            
        }

        $carrito->eliminarPorCliente($idCliente);

        $resultado["err"]= EXIT_SUCCESS;
        $resultado["mensaje"]="Pedido procesado exitosamente.";
        return view("web.carrito", compact("resultado",'aCarritos', 'aSucursales'));
    }
    }

    public function procesarMercadoPago(Request $request){
        $access_token=""; //aqui va el token de mercado pago -> Micuenta->Configuracion->Credenciales
        SDK::setClientId(config("payment-methods.mercadopago.client"));
        SDK::setClientsecret(config("payment-methods.mercadopago.secret"));
        SDK::setAccessToken($access_token);//Es el token de la cuenta de MercadoPAgo donde se deposita el dinero

        $idCliente = Session::get("idCliente");
        $sucursal=$request->input("lstSucursal");
        $pago = $request->input("lstPago");

        $cliente=new Cliente();
        $cliente->obtenerPorId($idCliente);

        $carrito = new Carrito();
        $aCarritos = $carrito->obtenerPorCliente($idCliente);

        $ventaSucursal = new Sucursal();
        $aSucursales = $ventaSucursal->obtenerTodos();

        $total = 0;
        foreach($aCarritos as $item){
            $total += $item->cantidad * $item->precio;
        }
        $fecha=date("Y-m-d");

        //Armando el producto item
        $item = new Item();
        $item->id = "1234";
        $item->title = "Burger SRL";
        $item->category_id = "products";
        $item->quantity = 1;
        $item->unit_price = $total;
        $item->currency_id = "COP"; //moneda

        $preference = new Preference();
        $preference->items = array($item);

        //Datos del comprador
        $payer = new Payer();
        $payer->name = $cliente->nombre;
        $payer->surname = "";
        $payer->email = $cliente->correo;
        $payer->date_created = date('Y-m-d H:m:s');
        $payer->identification = array(
            "type" => "DNI", //cc
            "number" => $cliente->dni
        );
        $preference->payer = $payer;

        $pedido = new Pedido();
        $pedido->fk_idsucursal=$ventaSucursal;
        $pedido->fk_idcliente=$idCliente;
        $pedido->fk_idestadopedido=5;
        $pedido->fecha = $fecha;
        $pedido->total=$total;
        $pedido->pago = $pago;
        $pedido->insertar();

        $pedidoProducto = new Pedido_producto();
        foreach($aCarritos as $item){

            $pedidoProducto->fk_idproducto = $item->fk_idproducto;
            $pedidoProducto->fk_idpedido = $pedido->idpedido;
            $pedidoProducto->cantidad = $item->cantidad;
            $pedidoProducto->insertar();
            
        }

        $carrito->eliminarPorCliente($idCliente);

        //URL de configuracion para indicarle a MP
        $preference->back_urls = [
            "success" => "http://127.0.0.1:800/mercado-pago/aprobado/" . $pedido->idpedido, //En la url, cuando se tenga la pagina, se coloca el dominio (puerto actualmente) seguido de las rutas que definimos
            "pending" => "http://127.0.0.1:800/mercado-pago/pendiente/" . $pedido->idpedido,
            "failure" => "http://127.0.0.1:800/mercado-pago/error/" . $pedido->idpedido,
        ];

        $preference->payment_methods = array("installments" => 6);
        $preference->auto_return = "all";
        $preference->notification_url = '';
        $preference->save(); //ejecuta la transacción
    }

}
