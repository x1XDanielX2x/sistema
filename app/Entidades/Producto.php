<?php 

namespace App\Entidades; //donde esta ubicado la entidad que estamos realizando, la actual hoja de trabajo

use DB;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model{

      protected $table = 'productos';//nombre de la tabla en bbdd
      public $timestamps = false; //colocar fecha y hora ne la bbdd de la insersion, marcas de tiempo

      protected $fillable = [ //Campos(columnas) de la table 'clientes' en la BBDD
            'idproducto','precio','fk_idTipoProducto','titulo','descripcion','cantidad','imagen'
      ];

      protected $hidden = []; //campos ocultos

      //metodos basicos

      public function cargarFormulario($request){
        $this->idproducto = $request->input('id') != "0" ? $request->input('id') : $this->idcliente;
        $this->fk_idTipoProducto = $request->input('txtTipoProducto');
        $this->precio = $request->input('txtPrecio');
        $this->cantidad = $request->input('txtCantidad');
        $this->descripcion = $request->input('txtDescripcion');
        $this->titulo = $request->input('txtTitulo');
        $this->imagen = $request->input('imagen');
      }

    public function obtenerTodos(){
        $sql="SELECT 
                idproducto,
                precio,
                fk_idTipoProducto,
                titulo,
                descripcion,
                cantidad,
                imagen
            FROM productos ORDER BY titulo ASC";

        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idProducto){
        $sql="SELECT 
                idproducto,
                precio,
                fk_idTipoProducto,
                titulo,
                descripcion,
                cantidad,
                imagen
            FROM productos WHERE idproducto = $idProducto";

        $lstRetorno = DB::select($sql);

        if(count($lstRetorno) > 0){
            $this->idproducto = $lstRetorno[0]->idproducto;
            $this->precio = $lstRetorno[0]->precio;
            $this->fk_idTipoProducto = $lstRetorno[0]->fk_idTipoProducto;
            $this->titulo = $lstRetorno[0]->titulo;
            $this->descripcion = $lstRetorno[0]->descripcion;
            $this->cantidad = $lstRetorno[0]->cantidad;
            $this->imagen = $lstRetorno[0]->imagen;
            return $this;
        }
        return null;

    }

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'titulo',
            1 => 'tipoproducto',
            2 => 'cantidad',
            3 => 'precio',
        );
        $sql = "SELECT DISTINCT
                idproducto,
                titulo,
                fk_idtipoproducto,
                cantidad,
                precio
            FROM productos
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( titulo LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR tipoproducto LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " cantidad LIKE '%" . $request['search']['value'] . "%' )";
            $sql .= " precio LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerPorTipo($idTipoProducto){
		$sql = "SELECT 
				idproducto,
				titulo,
				precio,
				cantidad,
				descripcion,
				imagen,
				fk_idtipoproducto
			FROM productos WHERE fk_idtipoproducto = $idTipoProducto";
		$lstRetorno = DB::select($sql);
	}

    public function guardar(){
        $sql = "UPDATE productos SET
                precio = $this->precio,
                fk_idTipoProducto = $this->fk_idTipoProducto,
                titulo = '$this-> titulo',
                descripcion = '$this -> descripcion',
                cantidad = $this -> cantidad,
                imagen = '$this -> imagen'
            WHERE idproducto=?"; //se refiere a que lo busca en al parametro siguiente :
        $affected = DB::update($sql, [$this->idproducto]);
    }

    public function eliminar(){
        $sql = "DELETE FROM productos WHERE
                idproducto=?";
        $affected = DB::delete($sql, [$this->idproducto]);
    }
    public function insertar(){
        $sql="INSERT INTO productos (
                precio,
                fk_idTipoProducto,
                titulo,
                descripcion,
                cantidad,
                imagen ) VALUES(
                ?,?,?,?,?,?);";
        $result = DB::insert($sql, [
            $this->precio,
            $this->fk_idTipoProducto,
            $this->titulo,
            $this->descripcion,
            $this->cantidad,
            $this->imagen,
        ]);
        return $this->idproducto = DB::getPdo()->lastInsertId();
    }
}
?>