// Constante para completar la ruta de la API.
const VALORACION_API = 'business/public/valoracion.php';
// Constante para establecer el contenedor de categorías.
const VALORACIONES = document.getElementById('valoraciones');
// Constante para establecer la modal de guardar.
const MODAL = new bootstrap.Modal(document.getElementById('staticBackdrop'));
// Constante para establecer la modal de guardar.
const MODAL2 = new bootstrap.Modal(document.getElementById('staticBackdrop2'));
// Constante para establecer el formulario de guardar.
const SAVE_FORM = document.getElementById('save-form');
// Constante para establecer el formulario de guardar.
const SAVE_FORM2 = document.getElementById('save-form2');
// Constante para establecer el título de la modal.
const MODAL_TITLE2 = document.getElementById('modal-title2');

// Constante tipo objeto para obtener los parámetros disponibles en la URL.
const PARAMS1 = new URLSearchParams(location.search);
const PARAMS2 = new URLSearchParams(location.search);

document.addEventListener('DOMContentLoaded', async () => {
});
// Método manejador de eventos para cuando se envía el formulario de guardar.
SAVE_FORM2.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (document.getElementById('id').value) ? action = 'update' : action = 'createRow';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM2);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(VALORACION_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTable();
        // Se cierra la caja de diálogo.
        MODAL2.hide();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

 function openCreate() {
        // Se restauran los elementos del formulario.
    SAVE_FORM2.reset();

    // Se asigna el título a la caja de diálogo.
    MODAL_TITLE2.textContent = 'Crear valoracion';
    
    document.getElementById('id').textContent = "id_producto";
    
}

async function openUpdate() {
    // Se define un objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id_producto', PARAMS1.get('id'));
    const JSON = await dataFetch(VALORACION_API, 'readAllPreview', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se abre la caja de diálogo que contiene el formulario.
        MODAL.show();
        MODAL_TITLE.textContent = 'Valoraciones';
        //document.getElementById('producto').textContent = id;
        JSON.dataset.forEach(row => {
            VALORACIONES.innerHTML += `
            <div class="col mt-4">
                <div class="card text-black">
                  <div class="card-body">
                    <h5 class="card-title">Valoracion</h5>
                    <p class="card-text">${row.comentario_producto}</p>
                    <p class="card-text">${row.calificacion_producto}</p>
                    <p class="card-text">${row.fecha_comentario}</p>
                  </div>
                </div>
            </div>
            `;
        });
    } else {
        // Se asigna al título del contenido de la excepción cuando no existen datos para mostrar.
        sweetAlert(2, JSON.exception, false);
    }
}