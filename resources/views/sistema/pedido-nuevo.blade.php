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
    <li class="btn-item"><a title="Eliminar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
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
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div id="msg"></div>
<div class="panel-body">
    <form id="form1" method="POST">
        <div class="row">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
            <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
            <div class="form-group col-6">
                <label>Cliente: *</label>
                <select id="txtCliente" name="txtCliente" class="form-control" value="" required>
                    <option value="" selected disabled>Seleccionar</option>
                    @foreach($aClientes as $cliente)

                    @if ($cliente->idcliente == $pedido->fk_idcliente): ?>
                    <option selected value="{{ $cliente->idcliente }}">{{ $cliente->nombre }}</option>
                    @else
                    <option value="{{ $cliente->idcliente }}">{{ $cliente->nombre }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group col-6">
                <label>Sucursal: *</label>
                <select id="txtSucursal" name="txtSucursal" class="form-control" value="" required>
                    <option value="" selected disabled>Seleccionar</option>
                    @foreach($aSucursales as $sucursal)

                    @if ($sucursal->idsucursal == $pedido->fk_idsucursal): ?>
                    <option selected value="{{ $sucursal->idsucursal }}">{{ $sucursal->nombre }}</option>
                    @else
                    <option value="{{ $sucursal->idsucursal }}">{{ $sucursal->nombre }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group col-6">
                <label>Medio de pago: *</label>
                <select id="lstMetodoPago" name="lstMetodoPago" class="form-control" value="" required>
                    <option value="" disable selected>Seleccionar</option>
                    <option <?php echo $pedido->pago == 'MercadoPago' ? 'selected' : ''; ?> value="MercadoPago">Mercado Pago</option>
                    <option <?php echo $pedido->pago == 'Efectivo' ? 'selected' : ''; ?> value="Efectivo">Efectivo</option>

                </select>
            </div>
            <div class="form-group col-6">
                <label>Estado del pedido: *</label>
                <select id="txtEstadoPedido" name="txtEstadoPedido" class="form-control" value="" required>
                    <option value="" selected disabled>Seleccionar</option>
                    @foreach($aEstadoPedidos as $estadopedido)

                    @if ($estadopedido->isestadopedido == $pedido->fk_idestadopedido): ?>
                    <option selected value="{{ $estadopedido->isestadopedido }}">{{ $estadopedido->nombre }}</option>
                    @else
                    <option value="{{ $estadopedido->isestadopedido }}">{{ $estadopedido->nombre }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group col-6">
                <label>Fecha: *</label>
                <input type="date" id="txtFecha" name="txtFecha" class="form-control" value="{{ $pedido->fecha }}" required>
            </div>
            <div class="form-group col-6">
                <label>Total: *</label>
                <input type="txt" id="txtTotal" name="txtTotal" class="form-control" value="{{ $pedido->total }}" required>
            </div>
        </div>
        @if($pedido->idpedido>0)
        <div class="row">
            <div class="col-12 pt-4 px-5">
                <h2>
                    Listado de productos
                </h2>
            </div>
            <div class="col-6 text-center py-4 px-5">
                <table class="table table-hover border">
                        <tr>
                            <th colspan="2">Producto</th>
                            <th>Cantidad</th>
                        </tr>
                        @foreach($aPedidoProductos as $pedido)

                            <tr>
                                <td><img src="/files/{{ $pedido->imagen }}" alt="" class="img-tumbnail" style="width: 90px;"></td>
                                <td>{{$pedido->titulo}}</td>
                                <td>{{$pedido->cantidad}}</td>
                            </tr>

                        @endforeach
                </table>
            </div>
        </div>
        @endif
    </form>
</div>
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

    function eliminar() {
        $.ajax({
            type: "GET",
            url: "{{ asset('admin/pedido/eliminar') }}",
            data: {
                id: globalId
            },
            async: true,
            dataType: "json",
            success: function(data) {
                if (data.err = 0) {
                    msgShow(data.mensaje, "success");
                    $("#btnEnviar").hide();
                    $("#btnEliminar").hide();
                    $('#mdlEliminar').modal('toggle');
                } else {
                    msgShow(data.mensaje, "danger");
                    $('#mdlEliminar').modal('toggle');

                }
            }
        });
    }
</script>
</div>
@endsection