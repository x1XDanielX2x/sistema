<?php 

namespace App\Entidades; //donde esta ubicado la entidad que estamos realizando, la actual hoja de trabajo

use DB;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model{

      protected $table = 'productos';//nombre de la tabla en bbdd
      public $timestamps = false; //colocar fecha y hora ne la bbdd de la insersion, marcas de tiempo

      protected $fillable = [ //Campos(columnas) de la table 'clientes' en la BBDD
            'idproducto','precio','fk_idtipoproducto','titulo','descripcion','cantidad','imagen'
      ];

      protected $hidden = []; //campos ocultos

      //metodos basicos

      public function cargarFormulario($request){
        $this->idproducto = $_REQUEST['id'] != "0" ? $_REQUEST['id'] : $this->idproducto;
        $this->fk_idtipoproducto = $_REQUEST['txtTipoProducto'];
        $this->precio = $_REQUEST['txtPrecio'];
        $this->cantidad = $_REQUEST['txtCantidad'];
        $this->descripcion = $_REQUEST['txtDescripcion'];
        $this->titulo = $_REQUEST['txtTitulo'];
        $this->imagen = $request->input('imagen');
      }

    public function obtenerTodos(){
        $sql="SELECT 
            P.idproducto,
            p.precio,
            p.fk_idtipoproducto,
            p.titulo,
            p.descripcion,
            p.cantidad,
            p.imagen,
            T.nombre as categoria
        FROM productos P
        INNER JOIN tipo_productos T on P.fk_idtipoproducto=T.idtipoproducto
        ORDER BY P.titulo ASC";

        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idProducto){
        $sql="SELECT 
                idproducto,
                precio,
                fk_idtipoproducto,
                titulo,
                descripcion,
                cantidad,
                imagen
            FROM productos WHERE idproducto = $idProducto";

        $lstRetorno = DB::select($sql);

        if(count($lstRetorno) > 0){
            $this->idproducto = $lstRetorno[0]->idproducto;
            $this->precio = $lstRetorno[0]->precio;
            $this->fk_idtipoproducto = $lstRetorno[0]->fk_idtipoproducto;
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
            0 => 'P.imagen',
            1 => 'P.titulo',
            2 => 'T.categoria',
            3 => 'P.cantidad',
            4 => 'P.precio'
        );
        $sql = "SELECT DISTINCT
                P.idproducto,
                P.imagen,
                P.titulo,
                P.fk_idtipoproducto,
                P.cantidad,
                P.precio,
                T.nombre as categoria
            FROM productos P
            INNER JOIN tipo_productos T ON P.fk_idtipoproducto = T.idtipoproducto
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( P.titulo LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR P.fk_idtipoproducto LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " P.cantidad LIKE '%" . $request['search']['value'] . "%' )";
            $sql .= " P.precio LIKE '%" . $request['search']['value'] . "%' )";
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

    public function obtenerProductosPorCategoria($idCategoria){
        $sql = "SELECT 
				idproducto,
				titulo,
				precio,
				cantidad,
				descripcion,
				imagen,
				fk_idtipoproducto
			FROM productos WHERE fk_idtipoproducto = $idCategoria";
		$lstRetorno = DB::select($sql);
    }

    public function guardar(){
        $sql = "UPDATE productos SET
                precio = $this->precio,
                fk_idtipoproducto = $this->fk_idtipoproducto,
                titulo = '$this->titulo',
                descripcion = '$this->descripcion',
                cantidad = $this->cantidad,
                imagen = '$this->imagen'
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
                fk_idtipoproducto,
                titulo,
                descripcion,
                cantidad,
                imagen ) VALUES(
                ?,?,?,?,?,?);";
        $result = DB::insert($sql, [
            $this->precio,
            $this->fk_idtipoproducto,
            $this->titulo,
            $this->descripcion,
            $this->cantidad,
            $this->imagen
        ]);
        return $this->idproducto = DB::getPdo()->lastInsertId();
    }
}
