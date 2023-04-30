// Constante para establecer el formulario de inicio de sesión.
const LOGIN_FORM = document.getElementById('login-form');

document.addEventListener('DOMContentLoaded', () => {
    const showPasswordButton = document.querySelector('#show-password');
    const passwordInput = document.querySelector('#pass');
  
    if (showPasswordButton) {
        const tooltip = new bootstrap.Tooltip(showPasswordButton, {
        title: 'Mostrar contraseña',
        placement: 'bottom',
        delay: { show: 0, hide: 100 }
    });
  
    showPasswordButton.addEventListener('click', () => {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        showPasswordButton.querySelector('i').classList.toggle('bi-eye-fill');
        showPasswordButton.querySelector('i').classList.toggle('bi-eye-slash-fill');
  
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
LOGIN_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(LOGIN_FORM);
    // Petición para iniciar sesión.
    const JSON = await dataFetch(USER_API, 'login', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        sweetAlert(1, JSON.message, true, 'home.html');
    } else {
        sweetAlert(2, JSON.exception, false);
    }

});