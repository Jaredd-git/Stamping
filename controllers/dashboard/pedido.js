// Constante para completar la ruta de la API.
const PEDIDO_API = 'business/dashboard/pedido.php';
const DETALLE_API = 'business/dashboard/detallepedido.php';
const PRODUCTO_API = 'business/dashboard/producto.php';
const TALLA_API = 'business/dashboard/talla.php';

// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
// Constante para establecer el formulario de guardar.
const SAVE_FORM = document.getElementById('save-form');
// Constante para establecer el título de la modal.
const MODAL_TITLE = document.getElementById('modal-title');
// Constantes para establecer el contenido de la tabla de pedidos.
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');
// Constantes para establecer el contenido de la tabla de detalle.
const TBODY_ROWS_DETAIL = document.getElementById('tbody-rows-detail');
const RECORDS_DETAIL = document.getElementById('records-detail');
// Constante para establecer la modal de guardar.
const MODAL = new bootstrap.Modal(document.getElementById('staticBackdrop'));
// Constante para establecer la modal de detalle.
const DETAIL_MODAL = new bootstrap.Modal(document.getElementById('detail-modal'));
// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para llenar la tabla con los registros disponibles.
    fillTable();
});

// Método manejador de eventos para cuando se envía el formulario de buscar.
SEARCH_FORM.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    fillTable(FORM);
});

// Método manejador de eventos para cuando se envía el formulario de guardar.
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(PEDIDO_API, 'changeStatus', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        MODAL.hide();
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTable();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

/*
*   Función asíncrona para llenar la tabla con los registros disponibles.
*   Parámetros: form (objeto opcional con los datos de búsqueda).
*   Retorno: ninguno.
*/
async function fillTable(form = null) {
    // Se inicializa el contenido de la tabla.
    TBODY_ROWS.innerHTML = '';
    RECORDS.textContent = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(PEDIDO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
                <tr>
                    <td>${row.id_pedido}</td>
                    <td>${row.cliente}</td>
                    <td>${row.estado}</td>
                    <td>${row.fecha_pedido}</td>
                    <td>${row.direccion_pedido}</td>
                    <th>
                        <button  onclick="openUpdate(${row.id_pedido})" class="btn btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Cambiar estado del pedido">
                            <i class="bi bi-check2-square"></i>
                        </button>
                        <button  onclick="openDetail(${row.id_pedido})" class="btn btn-outline-info" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ver detalle del pedido">
                            <i class="bi bi-file-text"></i>
                        </button>
                    </th>
                </tr>
            `;
        });
        // Se muestra un mensaje de acuerdo con el resultado.
        RECORDS.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function openUpdate(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id_pedido', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(PEDIDO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se abre la caja de diálogo que contiene el formulario.
        MODAL.show();
        // Se restauran los elementos del formulario.
        SAVE_FORM.reset();
        // Se asigna título a la caja de diálogo.
        MODAL_TITLE.textContent = 'Cambiar estado del pedido';
        // Se deshabilitan los campos necesarios.
        document.getElementById('id_pedido').readOnly = true;
        document.getElementById('fecha').disabled = true;
        document.getElementById('cliente').disabled = true;
        document.getElementById('direccion').disabled = true;
        // Se inicializan los campos del formulario.
        document.getElementById('id_pedido').value = JSON.dataset.id_pedido;
        document.getElementById('fecha').value = JSON.dataset.fecha_pedido;
        document.getElementById('cliente').value = JSON.dataset.cliente;
        document.getElementById('direccion').value = JSON.dataset.direccion_pedido;
        fillSelect(PEDIDO_API, 'readEstados', 'estado', JSON.dataset.id_estado);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

/*
*   Función asíncrona para obtener el detalle de un pedido.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function openDetail(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id_pedido', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(DETALLE_API, 'readAll', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se abre la caja de diálogo que contiene el formulario.
        DETAIL_MODAL.show();
        document.getElementById('pedido').textContent = id;
        TBODY_ROWS_DETAIL.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            subtotal = row.cantidad_producto * row.precio;
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS_DETAIL.innerHTML += `
                <tr>
                    <td>${row.nombre_producto}</td>
                    <td>${row.talla}</td>
                    <td>${row.cantidad_producto}</td>
                    <td>${row.precio}</td>
                    <td>${subtotal.toFixed(2)}</td>
                </tr>
            `;
        });
        // Se muestra un mensaje de acuerdo con el resultado.
        RECORDS_DETAIL.textContent = JSON.message;
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

/*
*   Función asíncrona para cambiar el estado de un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function openChangeStatus(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea cambiar el estado del pedido?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        //Se define una constante de tipo objeto con los datos del registro seleccionado 
        const FORM = new FormData();
        FORM.append('id_pedido', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(PEDIDO_API, 'changeStatus', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            fillTable();
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}
function openReport() {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/dashboard/pedidos.php`);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}