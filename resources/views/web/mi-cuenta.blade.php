@extends("web.plantilla")

@section("contenido")

<section class="layout_padding">
      <div class="container">
            <div class="heading_container">
                  <h2>
                        Datos del usuario
                  </h2>
            </div>
            <div class="row">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                  <div class="col-md-6">
                        <div class="form_container">
                              <form action="" method="post">
                                    <div>
                                          <label for="">Nombre:</label>
                                          <input type="text" name="txtNombre" id="txtNombre" class="form-control" placeholder="Nombre" value="{{ $cliente->nombre }}">
                                    </div>
                                    <div>
                                          <label for="">Telefono:</label>
                                          <input type="text" name="txtTelefono" id="txtTelefono" class="form-control" placeholder="Telefono" value="{{ $cliente->telefono }}">
                                    </div>
                                    <div>
                                          <label for="">Direccion:</label>
                                          <input type="text" name="txtDireccion" id="txtDireccion" class="form-control" placeholder="Direccion" value="{{ $cliente->direccion }}">
                                    </div>
                                    <div>
                                          <label for="">Correo:</label>
                                          <input type="text" name="txtCorreo" id="txtCorreo" class="form-control" placeholder="Correo" value="{{ $cliente->correo }}">
                                    </div>
                                    <div>
                                          <label for="">Documento:</label>
                                          <input type="text" name="txtDocumento" id="txtDocumento" class="form-control" placeholder="Documento" value="{{ $cliente->dni }}">
                                    </div>
                                    <div class="btn_box">
                                          <button type="submit">
                                                Guardar
                                          </button>
                                    </div>
                              </form>
                              <div><a href="/cambiar-clave">Cambiar contraseña</a></div>
                        </div>
                  </div>
            </div>
            <div class="row">
                  <div class="col-12">
                        <h2>
                              Pedidos Activos
                        </h2>
                  </div>
                  @if($aPedidos)
                  <div class="col-12">
                        
                        <table class="table table-hover border">
                              <thead>
                                    <tr>
                                    <th>Sucursal</th>
                                    <th>Pedido</th>
                                    <th>Estado Pedido</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    </tr>
                              </thead>
                              <tbody>
                                    @foreach($aPedidos as $pedido)
                                          <tr>
                                                <td>{{$pedido->Sucursal}}</td>
                                                <td>{{$pedido->idpedido}}</td>
                                                <td>{{$pedido->estado_del_pedido}}</td>
                                                <td>{{$pedido->fecha}}</td>
                                                <td>$ {{number_format($pedido->total,0,',','.')}}</td>
                                          </tr>
                                    @endforeach
                              </tbody>
                        </table>
                  </div>
                  @else
                        <div class="col-12">
                              <h4>
                                    No tienes pedidos actualmente.
                              </h4>
                        </div>
                  @endif
            </div>
      </div>
</section>

@endsection