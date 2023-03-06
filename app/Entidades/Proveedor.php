<?php 

namespace App\Entidades; //donde esta ubicado la entidad que estamos realizando, la actual hoja de trabajo

use DB;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model{

      protected $table = 'proveedores';//nombre de la tabla en bbdd
      public $timestamps = false; //colocar fecha y hora ne la bbdd de la insersion, marcas de tiempo

      protected $fillable = [ //Campos(columnas) de la table 'clientes' en la BBDD
            'idproveedor','nombre','direccion','nit','fk_idrubro'
      ];

      protected $hidden = []; //campos ocultos

      //metodos basicos

    public function obtenerTodos(){
        $sql="SELECT 
                idproveedor,
                nombre,
                direccion,
                nit,
                fk_idrubro,
                total
            FROM proveedores ORDER BY nombre DESC";

        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idProveedor){
        $sql="SELECT 
                idproveedor,
                nombre,
                direccion,
                nit,
                fk_idrubro,
                total
            FROM proveedores WHERE idproveedor = $idProveedor";

        $lstRetorno = DB::select($sql);

        if(count($lstRetorno) > 0){
            $this->idproveedor = $lstRetorno[0]->idproveedor;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->direccion = $lstRetorno[0]->direccion;
            $this->nit = $lstRetorno[0]->nit;
            $this->fk_idrubro = $lstRetorno[0]->fk_idrubro;
            return $this;
        }
        return null;

    }

    public function guardar(){
        $sql = "UPDATE proveedores SET
                nombre = '$this->nombre',
                fk_idsucursal = '$this-> direccion',
                nit = '$this->nit',
                fk_idrubro = $this -> fk_idrubro
            WHERE idproveedor=?"; //se refiere a que lo busca en al parametro siguiente :
        $affected = DB::update($sql, [$this->idproveedor]);
    }

    public function eliminar(){
        $sql = "DELETE FROM pedidos WHERE
                idproveedor=?";
        $affected = DB::delete($sql, [$this->idproveedor]);
    }
    public function insertar(){
        $sql="INSERT INTO proveedores (
                nombre,
                direccion,
                nit,
                fk_idrubro ) VALUES(
                ?,?,?,?);";
        $result = DB::insert($sql, [
            $this->nombre,
            $this->direccion,
            $this->nit,
            $this->fk_idrubro
        ]);
        return $this->idproveedor = DB::getPdo()->lastInsertId();
    }
}
?>