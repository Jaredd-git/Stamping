// Constante para completar la ruta de la API.
const VALORACIONES_API = 'business/dashboard/valoracion.php';
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
// Constante para establecer el título de la modal.
const MODAL_TITLE = document.getElementById('modal-title');
// Constantes para establecer el contenido de la tabla.
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');

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
    const JSON = await dataFetch(VALORACIONES_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            (row.estado_comentario) ? estado  = 'Activo' : estado = 'Inactivo';
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
                <tr>
                    <td>${row.id_producto}</td>
                    <td>${row.calificacion_producto}</td>
                    <td>${row.comentario_producto}</td>
                    <td>${row.fecha_comentario}</td>
                    <td>${estado}</td>
                    <th>
                        <button  onclick="openChangeStatus(${row.id_valoracion})" class="btn btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Cambiar estado del cliente">
                            <i class="bi bi-check2-square"></i>
                        </button>
                        <button  onclick="openDelete(${row.id_valoracion})" class="btn btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Eliminar Cliente">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </th>
                </tr>
            `;
        });

        // Se inicializa el componente Tooltip para que funcionen las sugerencias textuales.
        // M.Tooltip.init(document.querySelectorAll('.tooltipped'));
        // Se muestra un mensaje de acuerdo con el resultado.
        RECORDS.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

/*
*   Función asíncrona para eliminar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function openDelete(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el cliente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_valoracion', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(VALORACIONES_API, 'delete', FORM);
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

SEARCH_FORM.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    fillTable(FORM);
});

/*
*   Función asíncrona para cambiar el estado de un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function openChangeStatus(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea cambiar el estado del cliente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        const FORM = new FormData();
        FORM.append('id_valoracion', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(VALORACIONES_API, 'changeStatus', FORM);
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