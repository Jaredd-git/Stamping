// Constante para completar la ruta de la API.
const PRODUCTO_API = 'business/public/producto.php';
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
// Constante para establecer el contenedor de categorías.
const PRODUCTOS = document.getElementById('productos');
// Constante tipo objeto para establecer las opciones del componente Slider.
const OPTIONS = {
    height: 300
}

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Petición para obtener las categorías disponibles.
    const JSON = await dataFetch(PRODUCTO_API, 'readAllPreview');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se inicializa el contenedor de categorías.
        PRODUCTOS.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            PRODUCTOS.innerHTML += `
                <div class="col">
                    <div class="card text-black">
                        <img src="${SERVER_URL}images/productos/${row.imagen_producto}" class="card-img-top" alt="...">
                        <a href="verprenda.html?id=${row.id_producto}" class="btn btn-dark mt-2 ms-2 me-2" data-tooltip="Ver producto">
                            Ver producto
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">${row.nombre_producto}</h5>
                            <p class="card-text">${row.descripcion_producto}</p>
                            <p class="card-text">${row.precio_producto}</p>
                        </div>
                    </div>
                </div>
            `;
    });
  } else {
    // Se asigna al título del contenido de la excepción cuando no existen datos para mostrar.
    document.getElementById('title').textContent = JSON.exception;
  }
});

SEARCH_FORM.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    fillTable(FORM);
});

async function fillTable(form = null) {
    // Se verifica la acción a realizar.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(PRODUCTO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        PRODUCTOS.innerHTML = '';
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            PRODUCTOS.innerHTML += `
                <div class="col">
                    <div class="card text-black">
                        <img src="${SERVER_URL}images/productos/${row.imagen_producto}" class="card-img-top" alt="...">
                        <a href="verprenda.html?id=${row.id_producto}" class="btn btn-dark mt-2 ms-2 me-2" data-tooltip="Ver producto">
                            Ver producto
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">${row.nombre_producto}</h5>
                            <p class="card-text">${row.descripcion_producto}</p>
                            <p class="card-text">${row.precio_producto}</p>
                        </div>
                    </div>
                </div>
            `;
        });
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}
