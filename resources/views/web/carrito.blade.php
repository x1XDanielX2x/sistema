@extends("web.plantilla")

@section("contenido")

<section class="carrito">
      <div class="container">
            <div class="heading_container">
                  <h2>
                        Mi carrito
                  </h2>
            </div>
            @if(isset($msg))

            <div class="row">
                  <div class="col-12 tex-center">
                        <div class="alert alert-{{ $msg['err'] }}" role="alert">
                              {{ $msg["mensaje"] }}
                        </div>
                  </div>
            </div>

            @endif
            <div class="row">
                  @if($aCarritos)
                  <div class="col-9">
                        <div class="row mt-2 p-2">
                              <div class="col-md-12">
                                    <table class="table border table-hover">
                                          <thead>
                                                <tr>

                                                      <th colspan="2">Producto</th>
                                                      <th class="px-5">Precio</th>
                                                      <th class="px-5">Cantidad</th>
                                                      <th class="px-5">SubTotal</th>
                                                      
                                                </tr>
                                          </thead>
                                          <tbody>
                                                <!--@php ($subtotal =0) = Asi se declara una variable en blade-->
                                                <?php 
                                                      $total=0;
                                                ?>
                                                @foreach($aCarritos as $carrito)
                                                <?php 
                                                      $subtotal=$carrito->precio * $carrito->cantidad;
                                                      $total+=$subtotal;
                                                ?>
                                                <tr>
                                                      <form action="" method="POST">
                                                            
                                                            <td class="px-5">
                                                                  <img src="/files/{{$carrito->imagen}}" class="img-tumbnail">
                                                            </td>
                                                            <td>
                                                                  {{$carrito->titulo}}                                                                  
                                                            </td>

                                                            <td class="px-5">
                                                                  $ {{number_format($carrito->precio, 0, ',','.')}}
                                                            </td>
                                                            <td class="px-5">
                                                                  <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                                                                  <input type="hidden" name="txtProducto" id="txtProducto" value="{{$carrito->fk_idproducto}}">
                                                                  <input type="hidden" name="txtIdCarrito" id="txtIdCarrito" value="{{$carrito->idcarrito}}">
                                                                  <input type="number" name="txtCantidad" id="txtCantidad" value="{{$carrito->cantidad}}">
                                                            </td>
                                                            <td class="px-5">
                                                                  $ {{number_format(($subtotal), 0, ',','.')}}
                                                            </td>
                                                            <td class="px-5">
                                                                  <div class="btn-group">
                                                                        <button type="submit" class="btn-info" name="btnActualizar">Actualizar</button>
                                                                        <button type="submit" class="btn-danger" name="btnEliminar">Eliminar</button>
                                                                  </div>
                                                            </td>
                                                      </form>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                      <td colspan="4" style="text-align: right;">¿Te faltó algo?</td>
                                                      <td colspan="2" style="text-align: right;"><a class="btn btn-primary" href="takeaway">Continuar comprando</a></td>
                                                      <!--<td><button class="btn-border" name="btnFinalizar"><a href="#">Finalizar compra</a></button></td>-->
                                                </tr>
                                          </tbody>
                                    </table>
                              </div>
                        </div>
                  </div>
                  <div class="row">
                        <div class="mt-2 col-6 p-2 ">
                              <div class="col-md-12">
                                    <table class="table">
                                          <thead>
                                                <tr>
                                                      <th>
                                                            TOTAL: $ {{number_format($total,0,',','.')}}
                                                      </th>
                                                </tr>
                                          </thead>
                                          <form action="" method="post">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                                                <tbody>
                                                      <tr>
                                                            <td>
                                                                  <label for="">Sucursal:</label>
                                                                  <select name="lstSucursal" id="lstSucursal">
                                                                        <option value="" disabled selected requried>Seleccionar: *</option>
                                                                        @foreach($aSucursales as $sucursal)
                                                                              <option value="{{$sucursal->idsucursal}}">{{$sucursal->nombre}}</option>
                                                                        @endforeach
                                                                  </select>
                                                            </td>
                                                      </tr>
                                                      <tr>
                                                            <td>
                                                                  <label for="">Metodo de pago:</label>
                                                                  <select name="lstMetodoPago" id="lstMetodoPago">
                                                                        <option value="" selected disabled required>Seleccionar: *</option>
                                                                        <option value="MercadoPago">Mercado Pago</option>
                                                                        <option value="Efectivo">Efectivo</option>
                                                                  </select>
                                                            </td>
                                                      </tr>
                                                      <tr>
                                                            <td><button type="submit" class="btn btn-success" name="btnFinalizar">Finalizar compra</button></td>
                                                      </tr>
                                                </tbody>
                                          </form>
                                    </table>
                              </div>
                        </div>
                  </div>
                  @else
                  <div class="col-md-12 py-3">
                        <h4>
                              No hay productos seleccionados
                        </h4>
                  </div>
                  <button class="btn-border"><a href="takeaway">Ordenar</a></button>
                  @endif

            </div>
      </div>
</section>

@endsection