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
    <div class="container p-4 pb-0" style="background-color: #cccccc; height: 40px;">
        <section class="mb-4 row row-cols-1 row-cols-md-3 g-4">
            <!-- Nombre de la empresa -->
            <a style="text-align: left;" class="text-dark">Stamping Store</a>
            <!-- Enlaces a redes sociales -->
            <section>
                <a href="https://www.facebook.com/"><i><img style="width: 30px; " src="../../resources/img/iconos/Facebook.png"></i></a>
                <a href="https://www.instagram.com/"><i><img style="width: 30px;" src="../../resources/img/iconos/Instagram.png"></i></a>
                <a href="https://www.whatsapp.com/?lang=es"><i><img style="width: 30px;"
                    src="../../resources/img/iconos/Whatsapp.png"></i></a>
                <a href="https://www.pinterest.es/"><i><img style="width: 30px;" src="../../resources/img/iconos/Pinterest.png"></i></a>
            </section>
             <!-- Enlace a terminos y condiciones -->
            <section style="text-align: right;">
                <div class="row">
                    <a style="text-align: right;" class="text-dark">Terminos y condiciones</a>
                    <div class="col">
                        <a style="text-align: right;" class="text-dark" href="../../views/public/sobrenostros.html">Nosotros</a>
                        
                        <a style="text-align: right;" class="text-dark" href="../../views/public/">Contactanos</a>
                    </div>                    
                </div>             
            </section>
        </section>
    </div>
    <!-- Copyright de la empresa -->
    <div class="text-center p-3" style="background-color: rgba(204, 204, 204, 1);">
    © 2020 Copyright:
        <a class="text-dark" href="https://mdbootstrap.com/">Stamping</a>
    </div>
    `;