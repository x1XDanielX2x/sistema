@extends("web.plantilla")

@section("contenido")

<section class="carrito layout_padding">
      <div class="container">
            <div class="heading_container">
                  <h2>
                        Mi carrito
                  </h2>
            </div>

            <div class="row">
                  @if($aCarritos)
                  <div class="col-md-9">
                        <div class="row m-2 p-2">
                              <div class="col-md-12">
                                    <table class="table">
                                          <thead>
                                                <tr>
                                                      
                                                      <th colspan="2">Producto</th>
                                                      <th>Precio</th>
                                                      <th>Cantidad</th>
                                                      <th>Subtotal</th>
                                                </tr>
                                          </thead>
                                          <tbody>
                                                @foreach($aCarritos as $carrito)
                                                <tr>
                                                      <td>
                                                            <img src="/files/{{$carrito->imagen}}" class="img-tumbnail">
                                                            {{$carrito->titulo}}
                                                      </td>
                                                      
                                                      <td>
                                                            {{number_format($carrito->precio, 0, ',','.')}}
                                                      </td>
                                                      <td>
                                                            <input type="number" name="txtCantidad" id="txtCantidad" value="{{$carrito->cantidad}}">
                                                      </td>
                                                      <td>
                                                            {{$carrito->precio}}
                                                      </td>
                                                </tr>
                                                @endforeach
                                          </tbody>
                                    </table>
                              </div>
                        </div>
                        <button class="btn-border"><a href="takeaway.blade.php" >Continuar comprando</a></button>
                        <button class="btn-border"><a href="#" >Finalizar compra</a></button>
                  </div>
                  @else
                  <div class="col-md-12 py-3">
                        <h4>
                              No hay productos seleccionados
                        </h4>
                  </div>
                  <button class="btn-border"><a href="takeaway.blade.php" >Ordenar</a></button>
                  @endif
                  
            </div>
      </div>
</section>

@endsection