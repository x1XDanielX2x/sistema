<?php 

namespace App\Entidades; //donde esta ubicado la entidad que estamos realizando, la actual hoja de trabajo

use DB;
use Illuminate\Database\Eloquent\Model;

class Estado_Pedido extends Model{

      protected $table = 'estado_pedidos';//nombre de la tabla en bbdd
      public $timestamps = false; //colocar fecha y hora ne la bbdd de la insersion, marcas de tiempo

      protected $fillable = [ //Campos(columnas) de la table 'clientes' en la BBDD
            'isestadopedido','nombre'
      ];

      protected $hidden = []; //campos ocultos

      //metodos basicos

    public function obtenerTodos(){
        $sql="SELECT 
                isestadopedido,
                nombre
            FROM estado_pedidos ORDER BY isestadopedido ASC";

        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idEstadoPedido){
        $sql="SELECT 
                isestadopedido,
                nombre
            FROM estado_pedidos WHERE isestadopedido = $idEstadoPedido";

        $lstRetorno = DB::select($sql);

        if(count($lstRetorno) > 0){
            $this->isestadopedido = $lstRetorno[0]->isestadopedido;
            $this->nombre = $lstRetorno[0]->nombre;
            return $this;
        }
        return null;

    }

    public function guardar(){
        $sql = "UPDATE estado_pedidos SET
                nombre = '$this->nombre'
            WHERE isestadopedido=?"; //se refiere a que lo busca en al parametro siguiente :
        $affected = DB::update($sql, [$this->isestadopedido]);
    }

    public function eliminar(){
        $sql = "DELETE FROM estado_pedidos WHERE
                idestadopedido=?";
        $affected = DB::delete($sql, [$this->isestadopedido]);
    }
    public function insertar(){
        $sql="INSERT INTO estado_pedidos (
                nombre) VALUES(
                ?);";
        $result = DB::insert($sql, [
            $this->nombre
        ]);
        return $this->isestadopedido = DB::getPdo()->lastInsertId();
    }
}
?>