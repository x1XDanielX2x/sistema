@extends("web.plantilla")

@section("contenido")

<div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Recuperar clave</div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <h4>¿Olvidaste la clave?</h4>
                    <p>Ingresa la dirección de correo con la que te registraste y te enviaremos las instrucciones para cambiar la clave.</p>
                </div>
                <form name="fr" class="form-signin" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                    @if(isset($mensaje))
                    <div class="alert alert-secondary text-center" role="alert">
                        {{ $mensaje }}
                    </div>
                    @else
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="email" id="txtMail" name="txtMail" class="form-control" placeholder="Dirección de correo" required="required" autofocus="autofocus">
                        </div>
                    </div>
                    <button class="btn btn-primary btn-block" type="submit">Recuperar</button>
                    @endif
                </form>
            </div>
        </div>
    </div>

@endsection