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

      public function cargarFormulario($request){
        $this->idproveedor = $_REQUEST['id'] != "0" ? $_REQUEST['id'] : $this->idproveedor;
        $this->nombre = $_REQUEST['txtNombre'];
        $this->direccion = $_REQUEST['txtDireccion'];
        $this->nit = $_REQUEST['txtNit'];
        $this->fk_idrubro = $_REQUEST['txtIdRubro'];
      }

      //metodos basicos

    public function obtenerTodos(){
        $sql="SELECT 
                idproveedor,
                nombre,
                direccion,
                nit,
                fk_idrubro
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
                fk_idrubro
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

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'nombre',
            1 => 'direccion',
            2 => 'nit',
            3 => 'rubro',
        );
        $sql = "SELECT DISTINCT
                idproveedor,
                nombre,
                direccion,
                nit,
                fk_idrubro
            FROM proveedores
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR direccion LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " nit LIKE '%" . $request['search']['value'] . "%' )";
            $sql .= " fk_idrubro LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function guardar(){
        $sql = "UPDATE proveedores SET
                nombre = '$this->nombre',
                direccion = '$this->direccion',
                nit = '$this->nit',
                fk_idrubro = $this->fk_idrubro
            WHERE idproveedor=?"; //se refiere a que lo busca en al parametro siguiente :
        $affected = DB::update($sql, [$this->idproveedor]);
    }

    public function eliminar(){
        $sql = "DELETE FROM proveedores WHERE
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