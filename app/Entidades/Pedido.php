<?php 

namespace App\Entidades; //donde esta ubicado la entidad que estamos realizando, la actual hoja de trabajo

use DB;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model{

      protected $table = 'pedidos';//nombre de la tabla en bbdd
      public $timestamps = false; //colocar fecha y hora ne la bbdd de la insersion, marcas de tiempo

      protected $fillable = [ //Campos(columnas) de la table 'clientes' en la BBDD
            'idpedido','fk_idcliente','fk_idsucursal','fk_idestadopedido','fecha','total','pago'
      ];

      protected $hidden = []; //campos ocultos

      public function cargarFormulario($request){
        $this->idpedido = $_REQUEST["id"] != "0" ? $_REQUEST["id"] : $this->idpedido;
        $this->fk_idcliente = $_REQUEST["txtCliente"];
        $this->fk_idsucursal = $_REQUEST["txtSucursal"];
        $this->fk_idestadopedido = $_REQUEST["txtEstadoPedido"];
        $this->fecha = $_REQUEST["txtFecha"];
        $this->total = $_REQUEST["txtTotal"];
        $this->pago = $_REQUEST["lstMetodoPago"];
      }

      //metodos basicos

    public function obtenerTodos(){
        $sql="SELECT 
                idpedido,
                fk_idcliente,
                fk_idsucursal,
                fk_idestadopedido,
                fecha,
                total,                   //1:19
                pago
            FROM pedidos ORDER BY fecha DESC";

        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idPedido){
        $sql="SELECT 
                idpedido,
                fk_idcliente,
                fk_idsucursal,
                fk_idestadopedido,
                fecha,
                total,
                pago
            FROM pedidos WHERE idpedido = $idPedido";

        $lstRetorno = DB::select($sql);

        if(count($lstRetorno) > 0){
            $this->idpedido = $lstRetorno[0]->idpedido;
            $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
            $this->fk_idsucursal = $lstRetorno[0]->fk_idsucursal;
            $this->fk_idestadopedido = $lstRetorno[0]->fk_idestadopedido;
            $this->fecha = $lstRetorno[0]->fecha;
            $this->total = $lstRetorno[0]->total;
            $this->pago = $lstRetorno[0]->pago;
            return $this;
        }
        return null;

    }

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'fk_idsucursal',
            1 => 'fk_idestadopedido',
            2 => 'fecha',
            3 => 'total',
            4 => 'pago',
        );
        $sql = "SELECT DISTINCT
                    P.idpedido,
                    P.fk_idcliente,
                    P.fk_idsucursal,
                    P.fk_idestadopedido,
                    P.fecha,
                    P.total,
                    P.pago,
                    C.nombre AS Nombre_Cliente,
                    S.nombre AS Nombre_Sucursal,
                    E.nombre AS Estado_Pedido
                FROM pedidos P
                INNER JOIN clientes C ON P.fk_idcliente=C.idcliente
                INNER JOIN sucursales S ON P.fk_idsucursal=S.idsucursal
                INNER JOIN estado_pedidos E ON P.fk_idestadopedido=E.isestadopedido
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( fk_idsucursal LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR fk_idestadopedido LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " fecha LIKE '%" . $request['search']['value'] . "%' )";
            $sql .= " total LIKE '%" . $request['search']['value'] . "%' )";
            $sql .= " pago LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function guardar(){
        $sql = "UPDATE pedidos SET
                fk_idcliente = $this->fk_idcliente,
                fk_idsucursal = $this->fk_idsucursal,
                fk_idestadopedido = $this->fk_idestadopedido,
                fecha = '$this->fecha',
                total = $this->total,
                pago='$this->pago'
            WHERE idpedido=?"; //se refiere a que lo busca en al parametro siguiente :
        $affected = DB::update($sql, [$this->idpedido]);
    }

    public function eliminar(){
        $sql = "DELETE FROM pedidos WHERE
                idpedido=?";
        $affected = DB::delete($sql, [$this->idpedido]);
    }
    public function insertar(){
        $sql="INSERT INTO pedidos (
                fk_idcliente,
                fk_idsucursal,
                fk_idestadopedido,
                fecha,
                total,
                pago ) VALUES(
                ?,?,?,?,?,?);";
        $result = DB::insert($sql, [
            $this->fk_idcliente,
            $this->fk_idsucursal,
            $this->fk_idestadopedido,
            $this->fecha,
            $this->total,
            $this->pago
        ]);
        return $this->idpedido = DB::getPdo()->lastInsertId();
    }

    public function obtenerPedidosPorCliente($idCliente){
        $sql="SELECT 
                A.idpedido,
                A.fk_idcliente,
                A.fk_idsucursal,
                A.fk_idestadopedido,
                A.fecha,
                A.total,
                A.pago,
                B.nombre as Sucursal,
                C.nombre as estado_del_pedido
            FROM pedidos A 
            INNER JOIN sucursales B ON A.fk_idsucursal = B.idsucursal
            INNER JOIN estado_pedidos C ON A.fk_idestadopedido = C.isestadopedido
            WHERE fk_idcliente = '$idCliente' AND A.fk_idestadopedido <>3";

        $lstRetorno = DB::select($sql);
            
        return ($lstRetorno);
    }

    public function obtenerPedidosPorSucursal($idSucursal){
        $sql="SELECT 
                idpedido,
                fk_idcliente,
                fk_idsucursal,
                fk_idestadopedido,
                fecha,
                total,
                pago
            FROM pedidos WHERE fk_idsucursal = $idSucursal";

        $lstRetorno = DB::select($sql);
            
        return (count($lstRetorno) > 0);
    }
}

