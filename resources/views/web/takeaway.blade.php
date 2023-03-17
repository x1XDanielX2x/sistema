@extends("web.plantilla")

@section("contenido")
<!-- food section -->

<section class="food_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>
                Nuestro Menu
            </h2>
        </div>
        
        <ul class="filters_menu">
            <li class="active" data-filter="*">Todos</li>
            @foreach($aCategorias as $categoria)
            <li data-filter=".{{$categoria->nombre}}">{{ $categoria->nombre}}</li>
            @endforeach
        </ul>
        
        <div class="filters-content">
            @if(isset($msg))
            <div class="row">
                  <div class="col-md-6">
                       <div class="alert {{ $msg["ESTADO"] }}" role="alert">
                              {{ $msg["MSG"] }}
                       </div>
                  </div>
            </div>
            @endif

            <div class="row grid">
                

                @foreach($aProductos as $producto)
                <div class="col-sm-6 col-lg-4 all {{ $producto->categoria }}">
                    <div class="box">
                        <div>
                            <div class="img-box">
                                <img src="/files/{{ $producto->imagen }}" alt="">
                            </div>
                            <div class="detail-box">
                                <h5>
                                    {{ $producto->titulo }}
                                </h5>
                                <p>
                                    {{ $producto->descripcion }}
                                </p>
                                <div class="options border">
                                    
                                    <h6 class="col-3">
                                        ${{ number_format($producto->precio, 0, ',', '.')}}
                                    </h6>
                                    <form action="" method="POST" class="col-9">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                                        <input type="hidden" name="txtIdProducto" id="txtIdProducto" class="form-control" value="{{ $producto->idproducto }}">
                                        
                                        <div class="col-6"><input type="number" name="txtCantidad" id="txtCantidad" class="form-control" value="" style="width: 70px;"></div>   
                                        <div class="col-6"><button type="submit" class="btn-primary">Comprar</button></div>
                                        
                                        
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="btn-box">
            <a href="">
                Ver mas
            </a>
        </div>
    </div>
</section>

<!-- end food section -->

@endsection