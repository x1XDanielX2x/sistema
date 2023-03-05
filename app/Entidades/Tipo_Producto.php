<?php 

namespace App\Entidades; //donde esta ubicado la entidad que estamos realizando, la actual hoja de trabajo

use DB;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model{

      protected $table = 'tipo_productos';//nombre de la tabla en bbdd
      public $timestamps = false; //colocar fecha y hora ne la bbdd de la insersion, marcas de tiempo

      protected $fillable = [ //Campos(columnas) de la table 'clientes' en la BBDD
            'idtipoproducto','nombre'
      ];

      protected $hidden = []; //campos ocultos

      //metodos basicos

    public function obtenerTodos(){
        $sql="SELECT 
                idtipoproducto,
                nombre,
            FROM tipo_productos ORDER BY nombre ASC";

        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idTipoProducto){
        $sql="SELECT 
                idtipoproducto,
                nombre,
            FROM tipo_productos WHERE idtipoproducto = $idTipoProducto";

        $lstRetorno = DB::select($sql);

        if(count($lstRetorno) > 0){
            $this->idtipoproducto = $lstRetorno[0]->idtipoproducto;
            $this->nombre = $lstRetorno[0]->nombre;
            return $this;
        }
        return null;

    }

    public function guardar(){
        $sql = "UPDATE tipo_productos SET
                nombre = '$this->nombre',
            WHERE idtipoproducto=?"; //se refiere a que lo busca en al parametro siguiente :
        $affected = DB::update($sql, [$this->idtipoproducto]);
    }

    public function eliminar(){
        $sql = "DELETE FROM tipo_productos WHERE
                idtipoproducto=?";
        $affected = DB::delete($sql, [$this->idtipoproducto]);
    }
    public function insertar(){
        $sql="INSERT INTO tipo_productos (
                nombre) VALUES(
                ?);";
        $result = DB::insert($sql, [
            $this->nombre
        ]);
        return $this->idtipoproducto = DB::getPdo()->lastInsertId();
    }
}
?>