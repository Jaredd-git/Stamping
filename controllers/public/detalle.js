// Constantes para completar la ruta de la API.
const PRODUCTO_API = 'business/public/producto.php';
const PEDIDO_API = 'business/public/pedido.php';
const TALLA_API = 'business/public/talla.php';

// Constante tipo objeto para obtener los parámetros disponibles en la URL.
const PARAMS = new URLSearchParams(location.search);
// Constante para establecer el formulario de agregar un producto al carrito de compras.
const CART_FORM = document.getElementById('cart-form');


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
         document.getElementById('precio').textContent = ("Precio: " + JSON.dataset.precio_producto);
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


// function shoppingCart(event) {
//     // Se evita recargar la página web después de enviar el formulario.
//     event.preventDefault();
//     // Constante tipo objeto con los datos del formulario.
//     const FORM = new FormData(SHOPPING_FORM);
//     // Petición para guardar los datos del formulario.
//     dataFetch(PEDIDO_API, 'createDetail', FORM)
//         .then(JSON => {
//             // Se comprueba si la respuesta es satisfactoria, de lo contrario se constata si el cliente ha iniciado sesión.
//             if (JSON.status) {
//                 sweetAlert(1, JSON.message, false, 'cart.html');
//             } else if (JSON.session) {
//                 sweetAlert(2, JSON.exception, false);
//             } else {
//                 sweetAlert(3, JSON.exception, true, 'login.html');
//             }
//             // Abrir el offcanvas después de realizar todas las acciones.
//             document.getElementById('offcanvasRight').classList.add('show');
//         })
//         .catch(error => {
//             // Manejo de errores en caso de que la petición falle.
//             sweetAlert(4, 'Se produjo un error al enviar el formulario. Por favor, inténtalo de nuevo más tarde.', true);
//         });
// }