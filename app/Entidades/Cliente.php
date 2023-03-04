<?php 

namespace App\Entidades; //donde esta ubicado la entidad que estamos realizando, la actual hoja de trabajo

use DB;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model{

      protected $table = 'clientes';//nombre de la tabla en bbdd
      public $timestamps = false; //colocar fecha y hora ne la bbdd de la insersion, marcas de tiempo

      protected $fillable = [ //Campos(columnas) de la table 'clientes' en la BBDD
            'idcliente','nombre','telefono','direccion','dni','correo','clave'
      ];

      protected $hidden = []; //campos ocultos

      //metodos basicos

    public function obtenerTodos(){
        $sql="SELECT 
                idcliente,
                nombre,
                telefono,
                direccion,
                dni,
                correo,
                clave
            FROM clientes ORDER BY nombre ASC";

        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idcliente){
        $sql="SELECT 
                idcliente,
                nombre,
                telefono,
                direccion,
                dni,
                correo,
                clave
            FROM clientes WHERE idcliente = $idcliente";

        $lstRetorno = DB::select($sql);

        if(count($lstRetorno) > 0){
            $this->dicliente = $lstRetorno[0]->idcliente;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->telefono = $lstRetorno[0]->telefono;
            $this->direccion = $lstRetorno[0]->direccion;
            $this->dni = $lstRetorno[0]->dni;
            $this->correo = $lstRetorno[0]->correo;
            $this->clave = $lstRetorno[0]->clave;
            return $this;
        }
        return null;

    }

    public function guardar(){
        $sql = "UPDATE clientes SET
                nombre = '$this->nombre',
                telefono = '$this->telefono',
                direccion = '$this-> direccion',
                dni = '$this -> dni',
                correo = '$this -> correo',
                clave = '$this -> clave'
            WHERE idcliente=?"; //se refiere a que lo busca en al parametro siguiente :
        $affected = DB::update($sql, [$this->idcliente]);
    }

    public function eliminar(){
        $sql = "DELETE FROM clientes WHERE
                idcliente=?";
        $affected = DB::delete($sql, [$this->idcliente]);
    }
    public function insertar(){
        $sql="INSERT INTO clientes (
                nombre,
                telefono,
                direccion,
                dni,
                correo,
                clave ) VALUES(
                ?,?,?,?,?,?);";
        $result = DB::insert($sql, [
            $this->nombre,
            $this->telefono,
            $this->direccion,
            $this->dni,
            $this->correo,
            $this->clave,
        ]);
        return $this->idcliente = DB::getPdo()->lastInsertId();
    }

}





?>