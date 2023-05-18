// Constante para establecer el formulario de inicio de sesión.
const LOGIN_PUBLIC = document.getElementById('login-public');

/**
 * Event listener que se ejecuta cuando el DOM ha sido cargado.
 * Se encarga de obtener los elementos necesarios para mostrar/ocultar la contraseña y asignar un evento al botón correspondiente.
 */
document.addEventListener('DOMContentLoaded', () => {
    const showPasswordButton = document.querySelector('#show-password');
    const passwordInput = document.querySelector('#pass');
  
    // Se crea una instancia del tooltip de Bootstrap y se asignan las opciones.
    if (showPasswordButton) {
        const tooltip = new bootstrap.Tooltip(showPasswordButton, {
        title: 'Mostrar contraseña',
        placement: 'bottom',
        // Retraso para mostrar y ocultar la información
        delay: { show: 0, hide: 1 }
    });
  
    // Se asigna un evento al botón para cambiar el tipo de input y mostrar/ocultar la contraseña.
    showPasswordButton.addEventListener('click', () => {
        // Se verifica si el tipo de atributo "type" del elemento passwordInput es "password". Si es así, se establece el valor "text" a la variable type, de lo contrario se establece el valor "password".
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        // Cambia el ícono del botón de mostrar/ocultar contraseña
        showPasswordButton.querySelector('i').classList.toggle('bi-eye-fill');
        showPasswordButton.querySelector('i').classList.toggle('bi-eye-slash-fill');
        // Actualizar el título del tooltip según el estado actual del botón
        if (showPasswordButton.querySelector('i').classList.contains('bi-eye-slash-fill')) {
            tooltip._config.title = 'Ocultar contraseña';
            tooltip.show();
        } else {
            tooltip._config.title = 'Mostrar contraseña';
            tooltip.show();
        }
        });
    }
  });

// Método manejador de eventos para cuando se envía el formulario de inicio de sesión.
LOGIN_PUBLIC.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(LOGIN_PUBLIC);
    // Petición para iniciar sesión.
    const JSON = await dataFetch(USER_API, 'login', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        sweetAlert(1, JSON.message, true, 'index.html');
    } else {
        sweetAlert(2, JSON.exception, false);
    }

});