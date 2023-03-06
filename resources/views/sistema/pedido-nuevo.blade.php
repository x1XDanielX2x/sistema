@extends("plantilla")
@section("titulo",$titulo)

@section('scripts')
<script>
      globalId = '<?php echo isset($pedido->idpedido) && $pedido->idpedido > 0 ? $pedido->idpedido : 0; ?>';
      <?php $globalId = isset($pedido->idpedido) ? $pedido->idpedido : "0"; ?>
</script>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
      <li class="breadcrumb-item"><a href="/admin/pedidos">Pedidos</a></li>
      <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
      <li class="btn-item"><a title="Nuevo" href="/admin/pedido/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
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
                        <label>Cliente: *</label>
                        <select id="txtCliente" name="txtCliente" class="form-control" value="" required>
                              <option value="" selected disabled>Seleccionar cliente</option>
                              @foreach($aClientes as $cliente)
                                    <option value="{{ $cliente->idcliente }}">{{ $cliente->nombre }}</option>
                              @endforeach
                        </select>
                  </div>
                  <div class="form-group col-6">
                        <label>Sucursal: *</label>
                        <select id="txtSucursal" name="txtSucursal" class="form-control" value="" required>
                              <option value="" selected disabled>Seleccionar sucursal</option>
                              @foreach($aSucursales as $sucursal)
                                    <option value="{{$sucursal->idsucursal}}">{{$sucursal->nombre}}</option>
                              @endforeach
                        </select>
                  </div>
                  <div class="form-group col-6">
                        <label>Estado del pedido: *</label>
                        <select id="txtEstadoPedido" name="txtEstadoPedido" class="form-control" value="" required>
                              <option value="" selected disabled>Seleccionar estado</option>
                              @foreach($aEstadoPedidos as $estadopedido)
                                    <option value="{{$estadopedido->isestadopedido}}">{{$estadopedido->nombre}}</option>
                              @endforeach
                        </select>
                  </div>
                  <div class="form-group col-6">
                        <label>Fecha: *</label>
                        <input type="date" id="txtFecha" name="txtFecha" class="form-control" value="" required>
                  </div>
                  <div class="form-group col-6">
                        <label>Total: *</label>
                        <input type="txt" id="txtTotal" name="txtTotal" class="form-control" value="" required>
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