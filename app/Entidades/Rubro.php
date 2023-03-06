<?php 

namespace App\Entidades; //donde esta ubicado la entidad que estamos realizando, la actual hoja de trabajo

use DB;
use Illuminate\Database\Eloquent\Model;

class Rubro extends Model{

      protected $table = 'rublos';//nombre de la tabla en bbdd
      public $timestamps = false; //colocar fecha y hora ne la bbdd de la insersion, marcas de tiempo

      protected $fillable = [ //Campos(columnas) de la table 'clientes' en la BBDD
            'idrublo','nombre'
      ];

      protected $hidden = []; //campos ocultos

      public function cargarFormulario($request){
        $this->idrubro = $request->input('id') != "0" ? $request->input('id') : $this->idrubro;
        $this->nombre = $request->input('txtNombre');

      }

      //metodos basicos

    public function obtenerTodos(){
        $sql="SELECT 
                idrublo,
                nombre
            FROM rublos ORDER BY idrublo ASC";

        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idRublo){
        $sql="SELECT 
                idrublo,
                nombre
            FROM rublos WHERE idrublo = $idRublo";

        $lstRetorno = DB::select($sql);

        if(count($lstRetorno) > 0){
            $this->idrublo = $lstRetorno[0]->idrublo;
            $this->nombre = $lstRetorno[0]->nombre;
            return $this;
        }
        return null;

    }

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'nombre',

        );
        $sql = "SELECT DISTINCT
                idrubro,
                nombre
            FROM rublos
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( nombre LIKE '%" . $request['search']['value'] . "%' ";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function guardar(){
        $sql = "UPDATE rublos SET
                nombre = '$this->nombre'
            WHERE idrublo=?"; //se refiere a que lo busca en al parametro siguiente :
        $affected = DB::update($sql, [$this->idrublo]);
    }

    public function eliminar(){
        $sql = "DELETE FROM rublos WHERE
                idrublo=?";
        $affected = DB::delete($sql, [$this->idrublo]);
    }
    public function insertar(){
        $sql="INSERT INTO rublos (
                nombre) VALUES(
                ?);";
        $result = DB::insert($sql, [
            $this->nombre
        ]);
        return $this->idrublo = DB::getPdo()->lastInsertId();
    }
}
?>