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
            <li data-filter=".{{ $categoria->nombre }}">{{ $categoria->nombre}}</li>
            @endforeach
        </ul>

        <div class="filters-content">
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
                                <div class="options">
                                    <h6>
                                        ${{ number_format($producto->precio, 0, ',', '.')}}
                                    </h6>
                                    <form action="">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                                        <input type="hidden" name="txtIdProducto" id="txtIdProducto" class="form-control" value="{{ $producto->idproducto }}" >
                                        <input type="number" name="txtCantidad" id="txtCantidad" class="form-control" value="0" style="width: 70px;" required>
                                    </form>
                                    <button type="submit">Comprar</button>
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