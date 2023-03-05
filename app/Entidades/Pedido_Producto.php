<?php 

namespace App\Entidades; //donde esta ubicado la entidad que estamos realizando, la actual hoja de trabajo

use DB;
use Illuminate\Database\Eloquent\Model;

class Pedido_Producto extends Model{

      protected $table = 'pedido_productos';//nombre de la tabla en bbdd
      public $timestamps = false; //colocar fecha y hora ne la bbdd de la insersion, marcas de tiempo

      protected $fillable = [ //Campos(columnas) de la table 'clientes' en la BBDD
            'idpedidoproducto','fk_idproducto','fk_idpedido'
      ];

      protected $hidden = []; //campos ocultos

      //metodos basicos

    public function obtenerTodos(){
        $sql="SELECT 
                idpedidoproducto,
                fk_idproducto,
                fk_idpedido
            FROM pedido_productos ORDER BY idpedidoproducto ASC";

        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idPedidoProducto){
        $sql="SELECT 
                idpedidoproducto,
                fk_idproducto,
                fk_idpedido
            FROM pedido_productos WHERE idpedidoproducto = $idPedidoProducto";

        $lstRetorno = DB::select($sql);

        if(count($lstRetorno) > 0){
            $this->idpedidoproducto = $lstRetorno[0]->idpedidoproducto;
            $this->fk_idproducto = $lstRetorno[0]->fk_idproducto;
            $this->fk_idpedido = $lstRetorno[0]->fk_idpedido;
            return $this;
        }
        return null;

    }

    public function guardar(){
        $sql = "UPDATE pedido_productos SET
                fk_idproducto = $this->fk_idproducto,
                fk_idpedido = $this-> fk_idpedido
            WHERE idpedidoproducto=?"; //se refiere a que lo busca en al parametro siguiente :
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
                fk_idpedido
                ) VALUES(
                ?,?);";
        $result = DB::insert($sql, [
            $this->fk_idproducto,
            $this->fk_idpedido
        ]);
        return $this->idpedidoproducto = DB::getPdo()->lastInsertId();
    }
}
?>