<?php 

namespace App\Entidades; //donde esta ubicado la entidad que estamos realizando, la actual hoja de trabajo

use DB;
use Illuminate\Database\Eloquent\Model;

class Postulacion extends Model{

      protected $table = 'postulaciones';//nombre de la tabla en bbdd
      public $timestamps = false; //colocar fecha y hora ne la bbdd de la insersion, marcas de tiempo

      protected $fillable = [ //Campos(columnas) de la table 'clientes' en la BBDD
            'idpostulacion','nombre','apellido','telefono','correo','cv'
      ];

      protected $hidden = []; //campos ocultos

      //metodos basicos

    public function obtenerTodos(){
        $sql="SELECT 
                idpostulacion,
                nombre,
                apellido,
                telefono,
                correo,
                cv
            FROM postulaciones ORDER BY idpostulacion ASC";

        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idPostulacion){
        $sql="SELECT 
                idpostulacion,
                nombre,
                apellido,
                telefono,
                correo,
                cv
            FROM postulaciones WHERE idpostulacion = $idPostulacion";

        $lstRetorno = DB::select($sql);

        if(count($lstRetorno) > 0){
            $this->idpostulacion = $lstRetorno[0]->idpostulacion;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->apellido = $lstRetorno[0]->apellido;
            $this->telefono = $lstRetorno[0]->telefono;
            $this->correo = $lstRetorno[0]->correo;
            $this->cv = $lstRetorno[0]->cv;
            return $this;
        }
        return null;

    }

    public function guardar(){
        $sql = "UPDATE postulaciones SET
                nombre = '$this->nombre',
                apellido = '$this-> apellido',
                telefono = '$this->telefono',
                correo = '$this -> correo',
                cv = '$this -> cv'
            WHERE idpostulacion=?"; //se refiere a que lo busca en al parametro siguiente :
        $affected = DB::update($sql, [$this->idpostulacion]);
    }

    public function eliminar(){
        $sql = "DELETE FROM postulaciones WHERE
                idpostulacion=?";
        $affected = DB::delete($sql, [$this->idpostulacion]);
    }
    public function insertar(){
        $sql="INSERT INTO postulaciones (
                nombre,
                apellido,
                telefono,
                correo,
                cv ) VALUES(
                ?,?,?,?,?);";
        $result = DB::insert($sql, [
            $this->nombre,
            $this->apellido,
            $this->telefono,
            $this->correo,
            $this->cv
        ]);
        return $this->idpostulacion = DB::getPdo()->lastInsertId();
    }
}
?>