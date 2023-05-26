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
        CART_DATA.innerHTML = `
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-12">
                        <div class="card-body">
                            <h5 class="card-title" id="nombre_producto">Card title</h5>
                            <p class="card-text" id="precio_p">PRECIO ($US)</p>
                            <input type="number" class="form-control" min="1">
                            <p class="card-text" id="subtotal">SUBTOTAL</p>
                            <div class="row justify-content-end">
                                <!--Párrafo con texto alineado a la derecha y un elemento en negrita identificado como "pago"-->
                                <p class="text-end">TOTAL A PAGAR (US$) <b id="pago"></b></p>
                            </div>     
                        </div>
                    </div>
                </div>
            </div>`;
        // Se declara e inicializa una variable para calcular el importe por cada producto.
        let subtotal = 0;
        // Se declara e inicializa una variable para sumar cada subtotal y obtener el monto final a pagar.
        let total = 0;
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            subtotal = row.precio_producto * row.cantidad_producto;
            total += subtotal;
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            CART_DATA.innerHTML += `
                <div class="card-body">
                    <h5>${row.nombre_producto}</h5>
                    <p>${row.precio_producto}</p>
                    <input>${row.cantidad_producto}</input>
                    <p>${subtotal.toFixed(2)}</p>
                </div>
            `;
            // Actualizar el contenido del elemento offcanvasContent en el DOM
            document.getElementById('content-cart').innerHTML = offcanvasContent;
        });
        // Se muestra el total a pagar con dos decimales.
        document.getElementById('pago').textContent = total.toFixed(2);
    } else {
        sweetAlert(4, JSON.exception, false, 'verprenda.html');
    }
}