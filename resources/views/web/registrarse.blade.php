@extends("web.plantilla")

@section("contenido")

<section class="layout_padding">
      <div class="container">
            <div class="heading_container">
                  <h2>
                        Registrarse
                  </h2>
            </div>
            <div class="row">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                  <div class="col-md-6">
                        <div class="form_container">
                              <form action="" method="post">
                                    <div>
                                          <label for="">Nombre: *</label>
                                          <input type="text" name="txtNombre" id="txtNombre" class="form-control" placeholder="Ingrese su nombre">
                                    </div>
                                    <div>
                                          <label for="">Telefono: *</label>
                                          <input type="text" name="txtTelefono" id="txtTelefono" class="form-control" placeholder="Ingrese su telefono">
                                    </div>
                                    <div>
                                          <label for="">Direccion: *</label>
                                          <input type="text" name="txtDireccion" id="txtDireccion" class="form-control" placeholder="Ingrese su direccion">
                                    </div>
                                    <div>
                                          <label for="">Correo: *</label>
                                          <input type="text" name="txtCorreo" id="txtCorreo" class="form-control" placeholder="Ingrese su correo">
                                    </div>
                                    <div>
                                          <label for="">Documento: *</label>
                                          <input type="text" name="txtDocumento" id="txtDocumento" class="form-control" placeholder="Ingrese su documento">
                                    </div>
                                    <div class="btn_box">
                                          <button type="submit">
                                                Registrarse
                                          </button>
                                    </div>
                              </form>
                        </div>
                  </div>
            </div>
      </div>
</section>

@endsection