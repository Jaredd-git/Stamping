// Constantes para establecer las etiquetas de encabezado y pie de la página web.
const HEADER = document.querySelector('header');
const FOOTER = document.querySelector('footer');

/* Se manda al header codigo para usarlo en el html */
HEADER.innerHTML = `
    <!-- Navbar de la pagina web -->
    <div>
        <nav class="barra-nav navbar-ligth sticky-top" style="background-color: #ccc;">
            <div class="text-center p-4" >
                <a style="text-decoration: none;" class="text-reset fw-bold" href="home.html">STAMPING</a>
            </div>
        </nav>           
    </div>
    `;

/* Se manda al footer codigo para usarlo en el html */
FOOTER.innerHTML = `
  <!-- Copyright -->
  <div style="background-color: rgba(0, 0, 0, 0.05); ">
    © 2023 Copyright:
    <a class="text-reset fw-bold" style="text-decoration: none;" href="https://stamping.com/">Stamping.com</a>
  </div>
  <!-- Copyright -->
    `;

