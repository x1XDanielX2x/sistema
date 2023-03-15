@extends("web.plantilla")

@section("contenido")

<section class="layout_padding">
      <div class="container">
            <div class="heading_container">
                  <h2>
                        Ingresar al sistema
                  </h2>
            </div>
            @if(isset($mensaje))
            <div class="row">
                  <div class="col-md-6">
                       <div class="alert alert-danger" role="alert">
                              {{ $mensaje }}
                       </div>
                  </div>
            </div>
            @endif
            <div class="row">
                  <div class="col-md-6">
                        <div class="form_container">
                              <form action="" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                                    <div class="py-2">
                                          <label for="">Correo: *</label>
                                          <input type="text" name="txtCorreo" id="txtCorreo" class="form-control" placeholder="Ingrese su correo">
                                    </div>
                                    <div class="py-2">
                                          <label for="">Contraseña: *</label>
                                          <input type="password" name="txtClave" id="txtClave" class="form-control" placeholder="Ingrese su contraseña">
                                    </div>
                                    <div class="btn_box pt-3">
                                          <button type="submit" name="btnIngresar">
                                                Iniciar Sesion
                                          </button>
                                    </div>
                              </form>
                        </div>
                  </div>
            </div>
      </div>
</section>

@endsection