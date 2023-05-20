// Constante para completar la ruta de la API.
const PRODUCTO_API = 'business/public/producto.php'; 
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