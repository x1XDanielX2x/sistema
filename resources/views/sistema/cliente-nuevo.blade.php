<?php  //.blade==@ =  es una extension, que unifica el html con el 
?>

@extends("plantilla") <?php  //.extends, es para incluir heredar un archivo, en este caso la plantilla ya diseñada, y toda la cabera, algo asi, head de html  e (include_once) de php
                        ?>
@section('titulo',$titulo)

@section('scripts')
<script>
      globalId = '<?php echo isset($cliente->idcliente) && $cliente->idcliente > 0 ? $cliente->idcliente : 0; ?>';
      <?php $globalId = isset($cliente->idcliente) ? $cliente->idcliente : "0"; ?>
</script>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
      <li class="breadcrumb-item"><a href="/admin/clientes">Clientes</a></li>
      <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
      <li class="btn-item"><a title="Nuevo" href="/admin/cliente/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
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

@section('contenido') <?php // damos apertura al inicio de la  seccion, para hacer el contenido
                        ?>
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
                        <label>Nombre: *</label>
                        <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="" required>
                  </div>
                  <div class="form-group col-6">
                        <label>Telefono: *</label>
                        <input type="text" id="txtTelefono" name="txtTelefono" class="form-control" value="" required>
                  </div>
                  <div class="form-group col-6">
                        <label>Direccion: *</label>
                        <input type="text" id="txtDireccion" name="txtDireccion" class="form-control" value="" required>
                  </div>
                  <div class="form-group col-6">
                        <label>Numero Identificacion: *</label>
                        <input type="text" id="txtCedula" name="txtCedula" class="form-control" value="" required>
                  </div>
                  <div class="form-group col-6">
                        <label>Correo: *</label>
                        <input type="email" id="txtCorreo" name="txtCorreo" class="form-control" value="" required>
                  </div>
                  <div class="form-group col-6">
                        <label>Contraseña: *</label>
                        <input type="text" id="txtPassword" name="txtPassword" class="form-control" value="" required>
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
@endsection <?php // finalizamos el contenido de la seccion 'contenido'  <!-- @yield = dar definicion a una seccion de (blade = laravel), en este caso, se dice que aqui este div sera la seccion contenido -->
                        ?>