<?php 

namespace App\Entidades; //donde esta ubicado la entidad que estamos realizando, la actual hoja de trabajo

use DB;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model{

      protected $table = 'sucursales';//nombre de la tabla en bbdd
      public $timestamps = false; //colocar fecha y hora ne la bbdd de la insersion, marcas de tiempo

      protected $fillable = [ //Campos(columnas) de la table 'clientes' en la BBDD
            'idsucursal','nombre','direccion','telefono','mapa','horario'
      ];

      protected $hidden = []; //campos ocultos

      public function cargarFormulario($request){
        $this->idsucursal = $_REQUEST['id'] != "0" ? $_REQUEST['id'] : $this->idsucursal;
        $this->nombre = $_REQUEST['txtNombre'];
        $this->direccion = $_REQUEST['txtDireccion'];
        $this->telefono = $_REQUEST['txtTelefono'];
        $this->mapa = $_REQUEST['txtMapa'];
        $this->horario = $_REQUEST['txtHorario'];
      }

      //metodos basicos

    public function obtenerTodos(){
        $sql="SELECT 
                idsucursal,
                nombre,
                direccion,
                telefono,
                mapa,
                horario
            FROM sucursales ORDER BY nombre ASC";

        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idSucursal){
        $sql="SELECT 
                idsucursal,
                nombre,
                direccion,
                telefono,
                mapa,
                horario
            FROM sucursales WHERE idsucursal = $idSucursal";

        $lstRetorno = DB::select($sql);

        if(count($lstRetorno) > 0){
            $this->idsucursal = $lstRetorno[0]->idsucursal;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->direccion = $lstRetorno[0]->direccion;
            $this->telefono = $lstRetorno[0]->telefono;
            $this->mapa = $lstRetorno[0]->mapa;
            $this->horario = $lstRetorno[0]->horario;
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
            2 => 'telefono',
            3 => 'horario',
        );
        $sql = "SELECT DISTINCT
                idsucursal,
                nombre,
                telefono,
                direccion,
                horario
            FROM sucursales
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR telefono LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " direccion LIKE '%" . $request['search']['value'] . "%' )";
            $sql .= " horario LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function guardar(){
        $sql = "UPDATE sucursales SET
                nombre = '$this->nombre',
                direccion = '$this->direccion',
                telefono = '$this->telefono',
                mapa = '$this->mapa',
                horario = '$this->horario'
            WHERE idsucursal=?"; //se refiere a que lo busca en al parametro siguiente :
        $affected = DB::update($sql, [$this->idsucursal]);
    }

    public function eliminar(){
        $sql = "DELETE FROM sucursales WHERE
                idsucursal=?";
        $affected = DB::delete($sql, [$this->idsucursal]);
    }
    public function insertar(){
        $sql="INSERT INTO sucursales (
                nombre,
                direccion,
                telefono,
                mapa,
                horario ) VALUES(
                ?,?,?,?,?);";
        $result = DB::insert($sql, [
            $this->nombre,
            $this->direccion,
            $this->telefono,
            $this->mapa,
            $this->horario
        ]);
        return $this->idsucursal = DB::getPdo()->lastInsertId();
    }
}
?>