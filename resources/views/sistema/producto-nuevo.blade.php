@extends("plantilla")
@section("titulo",$titulo)

@section('scripts')
<script>
      globalId = '<?php echo isset($producto->idproducto) && $producto->idproducto > 0 ? $producto->idproducto : 0; ?>';
      <?php $globalId = isset($producto->idproducto) ? $producto->idproducto : "0"; ?>
</script>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
      <li class="breadcrumb-item"><a href="/admin/productos">Clientes</a></li>
      <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
      <li class="btn-item"><a title="Nuevo" href="/admin/producto/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
      <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
      </li>
      @if($globalId > 0)
      <li class="btn-item"><a title="Guardar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
      @endif
      <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
      function fsalir() {
            location.href = "/admin/sistema/menu";
      }
</script>
@endsection

@section('contenido')

<?php
if (isset($msg)) {
      echo '<div id = "msg"></div>';
      echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>

<div class="panel-body">
      <form id="form1" method="POST">
            <div class="row">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                  <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
                  <div class="form-group col-6">
                        <label>Titulo: *</label>
                        <input type="text" id="txtTitulo" name="txtTitulo" class="form-control" value="" required>
                  </div>
                  <div class="form-group col-6">
                        <label>Tipo producto: *</label>
                        <select id="txtTipoProducto" name="txtTipoProducto" class="form-control" value="" required>
                              <option value="" selected disabled>Seleccionar</option>
                              @foreach($aCategorias as $categoria)
                                    <option value="{{ $categoria->idtipoproducto }}">{{ $categoria->nombre }}</option>
                              @endforeach
                        </select>
                  </div>
                  <div class="form-group col-6">
                        <label>Precio: *</label>
                        <input type="text" id="txtPrecio" name="txtPrecio" class="form-control" value="" required>
                  </div>
                  <div class="form-group col-6">
                        <label>Cantidad: *</label>
                        <input type="number" id="txtCantidad" name="txtCantidad" class="form-control" value="" required>
                  </div>
                  <div class="form-group col-6">
                        <label>Descripcion: *</label>
                        <input type="text" id="txtDescripcion" name="txtDescripcion" class="form-control" value="" required>
                  </div>
                  <div class="col-6 form-group">
                    <label for="fileImagen">Imagen:*</label>
                    <input type="file" class="form-control-file" name="archivo" id="imagen">
                </div>
            </div>
      </form>
      <script>

    $("#form1").validate();

    function guardar() {
        if ($("#form1").valid()) {
            modificado = false;
            form1.submit();
        } else {
            $("#modalGuardar").modal('toggle');
            msgShow("Corrija los errores e intente nuevamente.", "danger");
            return false;
        }
    }
    </script>
</div>
@endsection