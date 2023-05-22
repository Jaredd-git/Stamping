// Constante para completar la ruta de la API.
const VALORACION_API = 'business/public/valoracion.php';
// Constante para establecer el contenedor de categorías.
const VALORACIONES = document.getElementById('valoraciones');
// Constante para establecer la modal de guardar.
const MODAL = new bootstrap.Modal(document.getElementById('staticBackdrop'));
// Constante para establecer el formulario de guardar.
const SAVE_FORM = document.getElementById('save-form');
// Constante para establecer el título de la modal.
const MODAL_TITLE = document.getElementById('modal-title');

async function openUpdate(id) {
    // Se define un objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id_producto', id);
    const JSON = await dataFetch(VALORACION_API, 'readAllPreview', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se abre la caja de diálogo que contiene el formulario.
        MODAL.show();
        //document.getElementById('producto').textContent = id;
        JSON.dataset.forEach(row => {
            VALORACIONES.innerHTML += `
            <div class="col">
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