<?php 

namespace App\Entidades; //donde esta ubicado la entidad que estamos realizando, la actual hoja de trabajo

use DB;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model{

      protected $table = 'pedidos';//nombre de la tabla en bbdd
      public $timestamps = false; //colocar fecha y hora ne la bbdd de la insersion, marcas de tiempo

      protected $fillable = [ //Campos(columnas) de la table 'clientes' en la BBDD
            'idpedido','fk_idcliente','fk_idsucursal','fk_idestadopedido','fecha','total'
      ];

      protected $hidden = []; //campos ocultos

      public function cargarFormulario($request){
        $this->idpedido = $request->input('id') != "0" ? $request->input('id') : $this->idpedido;
        $this->fk_idcliente = $request->input('txtCliente');
        $this->fk_idsucursal = $request->input('txtSucursal');
        $this->fk_idestadopedido = $request->input('txtEstadoPedido');
        $this->fecha = $request->input('txtFecha');
        $this->total = $request->input('txtTotal');
      }

      //metodos basicos

    public function obtenerTodos(){
        $sql="SELECT 
                idpedido,
                fk_idcliente,
                fk_idsucursal,
                fk_idestadopedido,
                fecha,
                total
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
                total
            FROM pedidos WHERE idpedido = $idPedido";

        $lstRetorno = DB::select($sql);

        if(count($lstRetorno) > 0){
            $this->idpedido = $lstRetorno[0]->idpedido;
            $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
            $this->fk_idsucursal = $lstRetorno[0]->fk_idsucursal;
            $this->fk_idestadopedido = $lstRetorno[0]->fk_idestadopedido;
            $this->fecha = $lstRetorno[0]->fecha;
            $this->total = $lstRetorno[0]->total;
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
        );
        $sql = "SELECT DISTINCT
                idpedido,
                fk_idsucursal,
                fk_idestadopedido,
                fecha,
                total
            FROM pedidos
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( fk_idsucursal LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR fk_idestadopedido LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " fecha LIKE '%" . $request['search']['value'] . "%' )";
            $sql .= " total LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function guardar(){
        $sql = "UPDATE pedidos SET
                fk_idcliente = $this->fk_idcliente,
                fk_idsucursal = $this-> fk_idsucursal,
                fk_idestadopedido = $this->fk_idestadopedido,
                fecha = '$this -> fecha',
                total = $this -> total
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
                total ) VALUES(
                ?,?,?,?,?);";
        $result = DB::insert($sql, [
            $this->fk_idcliente,
            $this->fk_idsucursal,
            $this->fk_idestadopedido,
            $this->fecha,
            $this->total,
        ]);
        return $this->idpedido = DB::getPdo()->lastInsertId();
    }

    public function obtenerPedidosPorCliente($idCliente){
        $sql="SELECT 
                idpedido,
                fk_idcliente,
                fk_idsucursal,
                fk_idestadopedido,
                fecha,
                total
            FROM pedidos WHERE fk_idcliente = $idCliente";

        $lstRetorno = DB::select($sql);
            
        return (count($lstRetorno) > 0);
    }
}
?>