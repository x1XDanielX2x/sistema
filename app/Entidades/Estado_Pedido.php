<?php 

namespace App\Entidades; //donde esta ubicado la entidad que estamos realizando, la actual hoja de trabajo

use DB;
use Illuminate\Database\Eloquent\Model;

class Estado_Pedido extends Model{

      protected $table = 'estado_pedidos';//nombre de la tabla en bbdd
      public $timestamps = false; //colocar fecha y hora ne la bbdd de la insersion, marcas de tiempo

      protected $fillable = [ //Campos(columnas) de la table 'clientes' en la BBDD
            'idestadopedido','nombre'
      ];

      protected $hidden = []; //campos ocultos

      //metodos basicos

    public function obtenerTodos(){
        $sql="SELECT 
                idestadopedido,
                nombre
            FROM estado_pedidos ORDER BY idestadopedido ASC";

        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idEstadoPedido){
        $sql="SELECT 
                idestadopedido,
                nombre
            FROM estado_pedidos WHERE idestadopedido = $idEstadoPedido";

        $lstRetorno = DB::select($sql);

        if(count($lstRetorno) > 0){
            $this->idestadopedido = $lstRetorno[0]->idestadopedido;
            $this->nombre = $lstRetorno[0]->nombre;
            return $this;
        }
        return null;

    }

    public function guardar(){
        $sql = "UPDATE estado_pedidos SET
                nombre = '$this->nombre'
            WHERE idestadopedido=?"; //se refiere a que lo busca en al parametro siguiente :
        $affected = DB::update($sql, [$this->idestadopedido]);
    }

    public function eliminar(){
        $sql = "DELETE FROM estado_pedidos WHERE
                idestadopedido=?";
        $affected = DB::delete($sql, [$this->idestadopedido]);
    }
    public function insertar(){
        $sql="INSERT INTO estado_pedidos (
                nombre) VALUES(
                ?);";
        $result = DB::insert($sql, [
            $this->nombre
        ]);
        return $this->idestadopedido = DB::getPdo()->lastInsertId();
    }
}
?>