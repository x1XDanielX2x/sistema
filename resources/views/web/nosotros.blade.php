@extends('web.plantilla')

@section('contenido')
<!-- about section -->

<section class="about_section layout_padding">
    <div class="container  ">

        <div class="row">
            <div class="col-md-6 ">
                <div class="img-box">
                    <img src="web/images/about-img.png" alt="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-box">
                    <div class="heading_container">
                        <h2>
                            Nosotros somos Feane
                        </h2>
                    </div>
                    <p>
                        There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration
                        in some form, by injected humour, or randomised words which don't look even slightly believable. If you
                        are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in
                        the middle of text. All
                    </p>
                    <a href="">
                        Leer Mas
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- end about section -->

<!-- client section -->

<section class="client_section layout_padding-bottom">
    <div class="container">
        <div class="heading_container heading_center psudo_white_primary mb_45">
            <h2>
                What Says Our Customers
            </h2>
        </div>
        <div class="carousel-wrap row ">
            <div class="owl-carousel client_owl-carousel">
                <div class="item">
                    <div class="box">
                        <div class="detail-box">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam
                            </p>
                            <h6>
                                Moana Michell
                            </h6>
                            <p>
                                magna aliqua
                            </p>
                        </div>
                        <div class="img-box">
                            <img src="web/images/client1.jpg" alt="" class="box-img">
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="box">
                        <div class="detail-box">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam
                            </p>
                            <h6>
                                Mike Hamell
                            </h6>
                            <p>
                                magna aliqua
                            </p>
                        </div>
                        <div class="img-box">
                            <img src="web/images/client2.jpg" alt="" class="box-img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6 center">
                <h2>Trabaja con nosotros</h2>
                <form action="" method="POST">
                    <input type="text" name="txtNombre" id="txtNombre" placeholder="Nombre" class="form-control py-2">
                    <input type="text" name="txtNombre" id="txtNombre" placeholder="Apellidos" class="form-control py-2" required>
                    <input type="email" name="txtCorreo" id="txtCorreo" placeholder="Correo electronico" class="form-control py-2" required>
                    <input type="text" name="txtTelefono" id="txtTelefono" placeholder="Numero de contacto" class="form-control py-2">
                    <label for="" class="pt-2">Hoja de vida: *</label>
                    <div class="my-2">
                        <input type="file" name="archivo" id="archivo" accept=".doc, .docx, .pdf">
                        <small class="d-block">Archivos admitidos: word y pdf.</small>
                    </div>
                    <button type="submit" class="text-center mt-4 btn-primary">Postular</button>
                </form>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
</section>

<!-- end client section -->
@endsection