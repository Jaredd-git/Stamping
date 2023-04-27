
const USER_API = 'business/dashboard/usuario.php';
// Constantes para establecer las etiquetas de encabezado y pie de la página web.
const HEADER = document.querySelector('header');
const FOOTER = document.querySelector('footer');

/* Se manda al header codigo para usarlo en el html */
document.addEventListener('DOMContentLoaded', async () => {

    // Constante para completar la ruta de la API.
    const JSON = await dataFetch(USER_API, 'getUser');
    if (JSON.session) {
        if (JSON.status) {
            HEADER.innerHTML = `
          <!-- Navbar de la pagina web -->
          <div>
                <nav class="navbar-ligth sticky-top" style="background-color: #ccc;">
                    <div class="text-center p-4" >
                    <a style="text-decoration: none;" class="text-reset fw-bold" href="home.html">STAMPING</a>
                  </div>
                </nav>  
                <div class="dropdown">
                    <button class="btn-secondary dropdown-toggle mt-3 ms-3" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Cuenta: <b>${JSON.username}</b>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                      <li><a class="dropdown-item" onClick="logOut()">Salir</a></li>
                    </ul>
                </div>         
          </div>
          `;

            /* Se manda al footer codigo para usarlo en el html */
            FOOTER.innerHTML = `
          <!-- Copyright -->
          <div style="background-color: rgba(0, 0, 0, 0.05); ">
            © 2023 Copyright:
            <a class="text-reset fw-bold" style="text-decoration: none;" href="https://us-tuna-sounds-images.voicemod.net/88463959-b331-4a6a-b9ee-9843ec1a9229-1665760464118.png">Stamping.com</a>
          </div>
          <!-- Copyright -->
            `;
        } else {


            /* Se manda al footer codigo para usarlo en el html */
            FOOTER.innerHTML = `
          <!-- Copyright -->
          <div style="background-color: rgba(0, 0, 0, 0.05); ">
            © 2023 Copyright:
            <a class="text-reset fw-bold" style="text-decoration: none;" href="https://us-tuna-sounds-images.voicemod.net/88463959-b331-4a6a-b9ee-9843ec1a9229-1665760464118.png">Stamping.com</a>
          </div>
          <!-- Copyright -->
            `;
        }
    }
})