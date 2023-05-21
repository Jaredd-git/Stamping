// Constante para completar la ruta de la API.
const USER_API = 'business/public/cliente.php';

// Constantes para establecer las etiquetas de encabezado y pie de la página web.
const HEADER = document.querySelector('header');
const FOOTER = document.querySelector('footer');

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    const JSON = await dataFetch(USER_API, 'getUser');
    // Se comprueba si el usuario está autenticado para establecer el encabezado respectivo.
    if (JSON.session) {
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
                            <div class="dropdown btn-group align-items-center">
                                <button class="btn btn-transparent" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <b>${JSON.username}</b>
                                    <span class="bi bi-person" style="font-size: 30px;"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end text-center py-3" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" type="button" class="btn btn-primary" onClick="logOut()">Cerrar sesión</a></li>
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
                                    <a class="nav-link" href="../../views/public/nuevosproductos.html">Nuevos diseños</a>
                                </li>
                            </div>
                            <div class="v-line"></div>
                            <li class="nav-item">
                                <a class="nav-link" href="../../views/public/todosproductos.html">Todos los productos</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        `;
    } else {
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
                                        <!--Botón de inicio de sesión-->
                                        <a href="login.html" class="btn btn-primary d-flex justify-content-center align-items-center mx-auto mb-2">
                                            <span class="bi bi-person me-2"></span>
                                            Iniciar sesión
                                        </a>                            
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <!--Enlace de registro-->
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
                                    <a class="nav-link" href="../../views/public/nuevosproductos.html">Nuevos diseños</a>
                                </li>
                            </div>
                            <div class="v-line"></div>
                            <li class="nav-item">
                                <a class="nav-link" href="../../views/public/todosproductos.html">Todos los productos</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        `;
    }
    /* Se manda al footer codigo para usarlo en el html */
    FOOTER.innerHTML = `
        <section class="justify-content-center justify-content-lg-between " style="height: 2px;">

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
            <a class="text-reset fw-bold" href="index.html">Stamping.com</a>
        </div>
        <!-- Copyright -->
    `;
    const shopcartBtn = document.getElementById('shopcart');
    // Agregar el manejador de eventos al botón del carrito
    shopcartBtn.addEventListener('click', () => {
    // Llamar a la función toggleOffcanvas() para abrir o cerrar el offcanvas
    toggleOffcanvas();
    });
});

    // Función para abrir o cerrar el offcanvas
    function toggleOffcanvas() {
        const offcanvas = document.getElementById('offcanvasRight');
        const offcanvasInstance = new bootstrap.Offcanvas(offcanvas);
        offcanvasInstance.toggle();
    }

    // Contenido del offcanvas
    const offcanvasContent = `
        <!--Offcanvas en la posición final (derecha)-->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel" data-bs-backdrop="static">
            <!--Encabezado del offcanvas-->
            <div class="offcanvas-header">
                <!-- Botón para cerrar el offcanvas -->
                <button type="button" class="btn-close text-reset ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <!-- Cuerpo del offcanvas -->
            <div class="offcanvasbody">
                <div class="row">
                    <div class="col-12">
                        <!-- Contenedor de imagen de encabezado-->
                        <div class="imagen">
                            <!-- Inserta una imagen con un identificador "imgHof" y un atributo "alt" para accesibilidad -->
                            <img id="imgHof" src="../../resources/img/Imagenes/hofc.png" alt="banner">
                        </div>
                    </div>
                </div>
                <!-- Formulario con método POST y tipo de codificación para envío de archivos -->
                <form method="post" id="save-frm" enctype="multipart/form-data">
                    <!-- Se crea un campo para leer los productos-->
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="productos" name="productos" readonly>
                        <label for="productos">PRODUCTOS</label>
                    </div>
                    <!-- Se crea un campo para actualizar y leer la cantidad-->
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" required>
                        <label for="cantidad">CANTIDAD</label>
                    </div>
                    <!-- Se crea un campo para leer el precio-->
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="precio" name="precio" readonly step="0.01">
                        <label for="precio">PRECIO (US$)</label>
                    </div>
                    <!-- Se crea un campo para leer el subtotal-->
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="subtotal" name="subtotal" readonly>
                        <label for="subtotal">SUBTOTAL</label>
                    </div>
                    <!-- Fila con alineación a la derecha -->
                    <div class="row justify-content-end">
                        <!--Párrafo con texto alineado a la derecha y un elemento en negrita identificado como "pago"-->
                        <p class="text-end">TOTAL A PAGAR (US$) <b id="pago"></b></p>
                    </div>                
                </form>
                <div class="row">
                    <!-- Contenedor de botones -->
                    <div class="col-12 btnn">
                        <div class="d-flex justify-content-center">
                            <!-- Botón con estilo de contorno, para actualizar el pedido del carrito-->
                            <button type="button" class="btn btn-outline-primary me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Actualizar Carrito">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <!-- Botón con estilo de contorno, para eliminar el pedido del carrito-->
                            <button type="button" class="btn btn-outline-secondary me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar Carrito">
                                <i class="bi bi-cart-x-fill"></i>
                            </button>
                            <!-- Botón con estilo de contorno, para pagar el pedido-->
                            <button type="button" class="btn btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Pagar">
                                <i class="bi bi-cash"></i>
                            </button>
                        </div>
                    </div>
                </div>                         
                <div class="row">
                    <div class="col-12">
                        <!--Contenedor de imagen para el pie del offcanvas-->
                        <div class="imagen">
                            <!-- Inserta otra imagen con un identificador "imgI" y un atributo "alt" para accesibilidad -->
                            <img id="imgFof" src="../../resources/img/Imagenes/hofc.png" alt="banner">
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    `;

    // Agregar el contenido del offcanvas al documento
    document.body.insertAdjacentHTML('beforeend', offcanvasContent);