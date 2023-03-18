@extends('web.plantilla')

@section('contenido')

<section>
      <div class="container">
            <div class="heading-container">
                  <h1>
                        Cambio de clave
                  </h1>
            </div>
      </div>
      <div class="row">
            <div class="col-md-6">
                  <div class="form_container">
                        @if(isset($msg))
                        <div class="row">
                              <div class="col-md-6">
                                    <div class="alert alert-{{$msg['ESTADO']}}" role="alert">
                                          {{ $msg["MSG"] }}
                                    </div>
                              </div>
                        </div>
                        @endif
                        <form action="" method="post">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                              <div>
                                    <label for="txtNuevaClave" required>Digita la nueva clave: *</label>
                                    <input type="password" name="txtNuevaClave" id="txtNuevaClave" placeholder="Nueva clave" class="form-control">
                              </div>
                              <div>
                                    <label for="txtRepetirNuevaClave" required>Repite la nueva clave: *</label>
                                    <input type="password" name="txtRepetirNuevaClave" id="txtRepetirNuevaClave" placeholder="Repetir nueva clave" class="form-control">
                              </div>

                              <button type="submit" class="btn-primary">Cambiar clave</button>
                        </form>
                  </div>
            </div>
      </div>
</section>

@endsection