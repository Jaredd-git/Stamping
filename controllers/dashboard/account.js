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
                    <section>
                        <a href="#"><i><img style="width: 40px; " src="../../resources/img/iconos/isearch.png"></i></a>
                        <a href="#"><i><img style="width: 32px;" src="../../resources/img/iconos/iuser.png"></i></a>
                        <a href="#"><i><img style="width: 32px;" src="../../resources/img/iconos/ibolsa.png"></i></a>
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
  <!-- Copyright -->
  <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
    © 2023 Copyright:
    <a class="text-reset fw-bold" href="https://stamping.com/">stamping.com</a>
  </div>
  <!-- Copyright -->
    `;