// Constante para completar la ruta de la API.
const PRODUCTO_API = 'bussines/public/producto.php';
// Constante para establecer el contenedor de categorías.
const PRODUCTOS = document.getElementById('productos');
// Constante tipo objeto para establecer las opciones del componente Slider.
const OPTIONS = {
    height: 300
}

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Petición para obtener las categorías disponibles.
    const JSON = await dataFetch(PRODUCTO_API, 'readAll');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se inicializa el contenedor de categorías.
        PRODUCTOS.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se establece la página web de destino con los parámetros.
            url = `articulos.html?id=${row.id_producto}&nombre=${row.nombre_producto}`;
            // Se crean y concatenan las tarjetas con los datos de cada categoría.
            PRODUCTOS.innerHTML += `
            <div class="col">
                <div class="card text-light">
                  <img src="${SERVER_URL}imagenes/categorias/${row.imagen_producto}" class="card-img-top" alt="...">
                  <div class="card-body">
                    <h5 class="card-title">${row.nombre_producto}</h5>
                    <p class="card-text">${row.descripcion_producto}</p>
                    <p class="card-text">${row.precio_producto}</p>
                    <a href="${url}" class="btn btn-primary">Ver producto</a>
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