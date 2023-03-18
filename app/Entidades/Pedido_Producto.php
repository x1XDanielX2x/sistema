<?php 

namespace App\Entidades; //donde esta ubicado la entidad que estamos realizando, la actual hoja de trabajo

use DB;
use Illuminate\Database\Eloquent\Model;

class Pedido_Producto extends Model{

      protected $table = 'pedido_productos';//nombre de la tabla en bbdd
      public $timestamps = false; //colocar fecha y hora ne la bbdd de la insersion, marcas de tiempo

      protected $fillable = [ //Campos(columnas) de la table 'clientes' en la BBDD
            'idpedidoproducto','fk_idproducto','fk_idpedido','cantidad'
      ];

      protected $hidden = []; //campos ocultos

      //metodos basicos

    public function obtenerTodos(){
        $sql="SELECT 
                idpedidoproductos,
                fk_idproducto,
                fk_idpedido,
                cantidad
            FROM pedido_productos ORDER BY idpedidoproductos ASC";

        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idPedidoProducto){
        $sql="SELECT 
                idpedidoproductos,
                fk_idproducto,
                fk_idpedido,
                cantidad
            FROM pedido_productos WHERE idpedidoproductos = $idPedidoProducto";

        $lstRetorno = DB::select($sql);

        if(count($lstRetorno) > 0){
            $this->idpedidoproducto = $lstRetorno[0]->idpedidoproducto;
            $this->fk_idproducto = $lstRetorno[0]->fk_idproducto;
            $this->fk_idpedido = $lstRetorno[0]->fk_idpedido;
            $this->cantidad = $lstRetorno[0]->cantidad;
            return $this;
        }
        return null;

    }

    public function guardar(){
        $sql = "UPDATE pedido_productos SET
                fk_idproducto = $this->fk_idproducto,
                fk_idpedido = $this->fk_idpedido,
                cantidad = $this->cantidad
            WHERE idpedidoproductos=?"; //se refiere a que lo busca en al parametro siguiente :
        $affected = DB::update($sql, [$this->idpedidoproducto]);
    }

    public function eliminar(){
        $sql = "DELETE FROM pedido_productos WHERE
                idpedidoproducto=?";
        $affected = DB::delete($sql, [$this->idpedidoproducto]);
    }
    public function insertar(){
        $sql="INSERT INTO pedido_productos (
                fk_idproducto,
                fk_idpedido,
                cantidad
                ) VALUES(
                ?,?,?);";
        $result = DB::insert($sql, [
            $this->fk_idproducto,
            $this->fk_idpedido,
            $this->cantidad
        ]);
        return $this->idpedidoproductos = DB::getPdo()->lastInsertId();
    }

    public function obtenerPorPedido($idPedido){
        $sql="SELECT 
                P.idpedidoproductos,
                P.fk_idproducto,
                P.fk_idpedido,
                P.cantidad,
                B.titulo,
                B.imagen
            FROM pedido_productos P 
            INNER JOIN productos B ON P.fk_idproducto = B.idproducto
            where P.fk_idpedido = $idPedido
            ORDER BY idpedidoproductos ASC";

        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
}
?>