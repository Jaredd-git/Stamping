// Constantes para establecer las etiquetas de encabezado y pie de la página web.
const HEADER = document.querySelector('header');
const FOOTER = document.querySelector('footer');

/* Se manda al header codigo para usarlo en el html */
HEADER.innerHTML = `
    <!-- Navbar de la pagina web -->
        <div class="sticky-top">
            <nav class="barra-nav navbar navbar-ligth sticky-top" style="background-color: #ccc;">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <span class="navbar-brand mb-0 h1">Stamping</span>
                    <section class="d-flex">
                        <div class="dropdown btn-group dropstart">
                            <button class="btn btn-transparent" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="bi bi-person" style="font-size: 30px;"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end text-center py-3" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <button class="btn btn-primary d-flex justify-content-center align-items-center mx-auto mb-2" type="submit">
                                        <span class="bi bi-person me-2"></span>
                                        Iniciar sesión
                                    </button>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <span class="align-middle">¿No tiene una cuenta?</span>
                                        <a class="btn btn-link text-decoration-none" href="signup.html">Regístrese</a>
                                    </li>
                                </li>
                            </ul>
                        </div>
                        <button class="btn btn-transparent" type="button" id="shopcart">
                            <span class="bi bi-bag-heart"" style="font-size: 28px;"></span>
                        </button>
                    </section>
                </div>
            </nav>
            <div class="collapse sticky-top" id="navbarToggleExternalContent">
                <div class="bg-ligth p-4 contenido-navbar opacity-75">
                    <ul class="nav flex-row">
                        <div class="flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="../../views/public/ofertas.html">Productos
                                    en
                                    oferta</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../../views/public/productos.html">Nuevos diseños</a>
                            </li>
                        </div>
                        <div class="v-line"></div>
                        <li class="nav-item">
                            <a class="nav-link" href="../../views/public/nuevosproductos.html">Todos los productos</a>
                        </li>
                    </ul>
                </div>
            </div>
    </div>
    `;

/* Se manda al footer codigo para usarlo en el html */
FOOTER.innerHTML = `
    <section class="justify-content-center justify-content-lg-between " style="height: 2px">

        <!-- Right -->
        <div>
            <a href="" class="me-4 text-reset">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="" class="me-4 text-reset">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="" class="me-4 text-reset">
                <i class="fab fa-google"></i>
            </a>
            <a href="" class="me-4 text-reset">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="" class="me-4 text-reset">
                <i class="fab fa-linkedin"></i>
            </a>
            <a href="" src="../../resources/img/iconos/Facebook.png" class="me-4 text-reset">
                <i></i>
            </a>
        </div>
        <!-- Right -->
    </section>
    <!-- Section: Social media -->

    <!-- Section: Links  -->
    <section class="">
        <div class="container text-center text-md-start mt-5">
            <!-- Grid row -->
            <div class="row mt-3">
                <!-- Grid column -->
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4">
                        Products
                    </h6>
                    <p>
                        <a href="https://www.facebook.com"><img src="../../resources/img/iconos/Facebook.png"></img></a>
                    </p>
                    <p>
                        <a href="https://www.instagram.com"><img src="../../resources/img/iconos/Instagram.png"></img></a>
                    </p>
                    <p>
                        <a href="https://www.whatsapp.com"><img src="../../resources/img/iconos/Whatsapp.png"></img></a>
                    </p>
                    <p>
                        <a href="https://www.pinterest.es"><img src="../../resources/img/iconos/Pinterest.png"></img></a>
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4">
                        Legalidad
                    </h6>
                    <p>
                        <a href="#!" class="text-reset">Terminos y condiciones</a>
                    </p>
                    <p>
                        <a href="#!" class="text-reset">Politica de reembolso</a>
                    </p>
                    <p>
                        <a href="#!" class="text-reset">Politica de devoluciones</a>
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4">Stamping</h6>
                    <p><i class="fas fa-home me-3"></i> Colonia Escalon, N# 10012, ES</p>
                    <p>
                        <i class="fas fa-envelope me-3"></i>
                        stamping@gmail.com
                    </p>
                    <p><i class="fas fa-phone me-3"></i> + 503 2345-6788</p>
                    <p><i class="fas fa-print me-3"></i> + 503 2345-6789</p>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->
        </div>
    </section>
    <!-- Section: Links  -->

    <!-- Copyright -->
    <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
        © 2023 Copyright:
        <a class="text-reset fw-bold" href="https://stamping.com/">stamping.com</a>
    </div>
    <!-- Copyright -->
    `;