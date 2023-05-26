// Constantes para completar la ruta de la API.
const PRODUCTO_API = 'business/public/producto.php';
const PEDIDO_API = 'business/public/pedido.php';
const TALLA_API = 'business/public/talla.php';

// Constante tipo objeto para obtener los parámetros disponibles en la URL.
const PARAMS = new URLSearchParams(location.search);
// Constante para establecer el formulario de agregar un producto al carrito de compras.
const CART_FORM = document.getElementById('cart-form');
// Constante para establecer el cuerpo del carrito.
const CART_DATA = document.getElementById('content-cart');

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para mostrar los productos del carrito de compras.
    readOrderDetail();
});

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {

     // Constante tipo objeto con los datos del producto seleccionado.
     const FORM = new FormData();
     FORM.append('id_producto', PARAMS.get('id'));
     // Petición para solicitar los datos del producto seleccionado.
     const JSON = await dataFetch(PRODUCTO_API, 'readOne', FORM);
    fillSelect(TALLA_API, 'readAll', 'talla');
     // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
     if (JSON.status) {
         document.getElementById('title').textContent = "Informacion de Prenda";
         // Se colocan los datos en la página web de acuerdo con el producto seleccionado previamente.
         document.getElementById('imagen').src = SERVER_URL.concat('images/productos/', JSON.dataset.imagen_producto);
         document.getElementById('nombre').textContent = JSON.dataset.nombre_producto;
         document.getElementById('descripcion').innerHTML = `Descripcion: ${JSON.dataset.descripcion_producto}`;
         document.getElementById('precio').textContent = ("Precio: " + '$' + JSON.dataset.precio_producto);
         document.getElementById('id_producto').value = JSON.dataset.id_producto;
     } else {
         // Se presenta un mensaje de error cuando no existen datos para mostrar.
         document.getElementById('title').textContent = JSON.exception;
     }
});

// Método manejador de eventos para cuando se envía el formulario de agregar un producto al carrito.
CART_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(CART_FORM);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(PEDIDO_API, 'createDetail', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se constata si el cliente ha iniciado sesión.
    if (JSON.status) {
        sweetAlert(1, JSON.message, true);
        const OFFCANVAS = new bootstrap.Offcanvas(document.getElementById('cart-offcanvas'));
        OFFCANVAS.toggle();
    } else if (JSON.session) {
        sweetAlert(2, JSON.exception, false);
    } else {
        sweetAlert(3, JSON.exception, true, 'login.html');
    }
});

/*
*   Función para obtener el detalle del carrito de compras.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function readOrderDetail() {
    // Petición para obtener los datos del pedido en proceso.
    const JSON = await dataFetch(PEDIDO_API, 'readOrderDetail');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se inicializa el cuerpo de la tabla.
        CART_DATA.innerHTML = '';
        // Se declara e inicializa una variable para calcular el importe por cada producto.
        let subtotal = 0;
        // Se declara e inicializa una variable para sumar cada subtotal y obtener el monto final a pagar.
        let total = 0;
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            JSON.dataset
            subtotal = row.precio * row.cantidad_producto;
            total += subtotal;
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            CART_DATA.innerHTML += `
                <div class="card-body">
                    <h5>${row.nombre_producto}</h5>
                    <p>$${row.precio}</p>
                    <input type="number" class="form-control" min="1" value="${row.cantidad_producto}">
                    <p>$${subtotal.toFixed(2)}</p>
                </div>
                <div class="row" id="buttons-cart">
                    <div class="col-12 btnn">
                        <div class="d-flex justify-content-center">
                            <!-- Botón con estilo de contorno, para actualizar el pedido del carrito-->
                            <button onclick="openUpdateDetalle(${row.id_detalle}, ${row.cantidad_producto})" type="button" class="btn btn-outline-primary me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Actualizar Carrito">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <!-- Botón con estilo de contorno, para eliminar el pedido del carrito-->
                            <button onclick="openDelete(${row.id_detalle})" type="button" class="btn btn-outline-secondary me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar Carrito">
                                <i class="bi bi-cart-x-fill"></i>
                            </button>
                            <!-- Botón con estilo de contorno, para pagar el pedido-->
                            <button onclick="finishOrder()" type="button" class="btn btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Pagar">
                                <i class="bi bi-cash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
        });
        // Se muestra el total a pagar con dos decimales.
        document.getElementById('pago').textContent = total.toFixed(2);
    } else {
        sweetAlert(4, JSON.exception, false, 'verprenda.html');
    }
}

/*
*   Función para abrir la caja de diálogo con el formulario de cambiar cantidad de producto.
*   Parámetros: id (identificador del producto) y quantity (cantidad actual del producto).
*   Retorno: ninguno.
*/
function openUpdateDetail(id, quantity) {
    // Se inicializan los campos del formulario con los datos del registro seleccionado.
    document.getElementById('id_detalle').value = id;
    document.getElementById('cantidad').value = quantity;
}

/*
*   Función asíncrona para mostrar un mensaje de confirmación al momento de eliminar un producto del carrito.
*   Parámetros: id (identificador del producto).
*   Retorno: ninguno.
*/
async function openDeleteDetail(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Está seguro de remover el producto?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        FORM.append('id_detalle', id);
        // Petición para eliminar un producto del carrito de compras.
        const JSON = await dataFetch(PEDIDO_API, 'deleteDetail', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            readOrderDetail();
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}

async function finishOrder() {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Está seguro de finalizar el pedido?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Petición para finalizar el pedido en proceso.
        const JSON = await dataFetch(PEDIDO_API, 'finishOrder');
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            sweetAlert(1, JSON.message, true, 'todosproductos.html');
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}