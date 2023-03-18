@extends("web.plantilla")

@section("contenido")

  <!-- book section -->
  <section class="book_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
          Contactanos
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
        <div class="col-md-6">
          <div class="form_container">
            <form action="">
              <div>
                <input type="text" name="txtNombre" id="txtNombre" class="form-control" placeholder="Tu nombre" />
              </div>
              <div>
                <input type="text" name="txtTelefono" id="txtTelefono" class="form-control" placeholder="Tu numero" />
              </div>
              <div>
                <input type="email" name="txtCorreo" id="txtCorreo" class="form-control" placeholder="Tu correo" />
              </div>
              
              <div>
                <textarea name="txtComentario" id="txtComentario" class="form-control" placeholder="Dejanos tu comentario"></textarea>
              </div>
              <div class="btn_box">
                <button type="submit">
                  Enviar
                </button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-6">
          <div class="map_container ">
            <div id="googleMap"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end book section -->

  @endsection