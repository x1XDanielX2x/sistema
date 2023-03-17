<?php 

namespace App\Entidades; //donde esta ubicado la entidad que estamos realizando, la actual hoja de trabajo

use DB;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model{

      protected $table = 'carritos';//nombre de la tabla en bbdd
      
      public $timestamps = false; //colocar fecha y hora ne la bbdd de la insersion, marcas de tiempo

      protected $fillable = [ //Campos(columnas) de la table 'clientes' en la BBDD
            'idcarrito','fk_idcliente','fk_idproducto', 'cantidad'
      ];

      protected $hidden = []; //campos ocultos

      //metodos basicos

    public function obtenerTodos(){
        $sql="SELECT 
                idcarrito,
                fk_idcliente,
                fk_idproducto,
                cantidad
            FROM carritos ORDER BY idcarrito ASC";

        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idCarrito){
        $sql="SELECT 
                idcarrito,
                fk_idcliente,
                fk_idproducto,
                cantidad
            FROM carritos WHERE idcarrito = $idCarrito";

        $lstRetorno = DB::select($sql);

        if(count($lstRetorno) > 0){
            $this->idcarrito = $lstRetorno[0]->idcarrito;
            $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
            $this->fk_idproducto = $lstRetorno[0]->fk_idproducto;
            $this->cantidad = $lstRetorno[0]->cantidad;
            return $this;
        }
        return null;
    }

    public function obtenerPorCliente($idCliente){
        $sql="SELECT 
                C.idcarrito,
                C.fk_idcliente,
                C.fk_idproducto,
                C.cantidad,
                P.idproducto,
                P.titulo,
                P.precio,
                P.imagen
            FROM carritos C
            INNER JOIN productos P ON C.fk_idproducto = P.idproducto;
            WHERE C.fk_idcliente == $idCliente";

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function guardar(){
        $sql = "UPDATE carritos SET
                fk_idcliente = $this->fk_idcliente,
                fk_idproducto = $this-> fk_idproducto,
                cantidad = $this->cantidad,
            WHERE idcarrito=?"; //se refiere a que lo busca en al parametro siguiente :
        $affected = DB::update($sql, [$this->idcarrito]);
    }

    public function eliminar(){
        $sql = "DELETE FROM carritos WHERE
                idcarrito=?";
        $affected = DB::delete($sql, [$this->idcarrito]);
    }

    public function insertar(){
        $sql="INSERT INTO carritos (
                fk_idcliente,
                fk_idproducto,
                cantidad
                ) VALUES(
                ?,?,?);";
        $result = DB::insert($sql, [
            $this->fk_idcliente,
            $this->fk_idproducto,
            $this->cantidad
        ]);
        return $this->idcarrito = DB::getPdo()->lastInsertId();
    }
}
?>