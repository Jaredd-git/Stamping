const SIGNUP_FORM = document.getElementById('signup_form');

/**
 * Event listener que se ejecuta cuando el DOM ha sido cargado.
 * Se encarga de obtener los elementos necesarios para mostrar/ocultar la contraseña y asignar un evento al botón correspondiente.
 */
document.addEventListener('DOMContentLoaded', () => {
    const showPasswordButton1 = document.querySelector('#show-password1');
    const showPasswordButton2 = document.querySelector('#show-password2');
    const passwordInput1 = document.querySelector('#pass');
    const passwordInput2 = document.querySelector('#confirmar_clave');

    // Se crea una instancia del tooltip de Bootstrap y se asignan las opciones.
    if (showPasswordButton1) {
        const tooltip1 = new bootstrap.Tooltip(showPasswordButton1, {
            title: 'Mostrar contraseña',
            placement: 'bottom',
            // Retraso para mostrar y ocultar la información
            delay: { show: 0, hide: 1 }
        });

        if (showPasswordButton2) {
            const tooltip2 = new bootstrap.Tooltip(showPasswordButton2, {
                title: 'Mostrar contraseña',
                placement: 'bottom',
                // Retraso para mostrar y ocultar la información
                delay: { show: 0, hide: 1 }
            });
        }
        // Se asigna un evento al botón para cambiar el tipo de input y mostrar/ocultar la contraseña.
        showPasswordButton1.addEventListener('click', () => {
            // Se verifica si el tipo de atributo "type" del elemento passwordInput es "password". Si es así, se establece el valor "text" a la variable type, de lo contrario se establece el valor "password".
            const type = passwordInput1.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput1.setAttribute('type', type);
            // Cambia el ícono del botón de mostrar/ocultar contraseña
            showPasswordButton1.querySelector('i').classList.toggle('bi-eye-fill');
            showPasswordButton1.querySelector('i').classList.toggle('bi-eye-slash-fill');
            // Actualizar el título del tooltip según el estado actual del botón
            if (showPasswordButton1.querySelector('i').classList.contains('bi-eye-slash-fill')) {
                tooltip1._config.title = 'Ocultar contraseña';
                tooltip1.show();
            } else {
                tooltip1._config.title = 'Mostrar contraseña';
                tooltip1.show();
            }
        });
    }

    showPasswordButton2.addEventListener('click', () => {
        // Se verifica si el tipo de atributo "type" del elemento passwordInput es "password". Si es así, se establece el valor "text" a la variable type, de lo contrario se establece el valor "password".
        const type = passwordInput2.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput2.setAttribute('type', type);
        // Cambia el ícono del botón de mostrar/ocultar contraseña
        showPasswordButton2.querySelector('i').classList.toggle('bi-eye-fill');
        showPasswordButton2.querySelector('i').classList.toggle('bi-eye-slash-fill');
        // Actualizar el título del tooltip según el estado actual del botón
        if (showPasswordButton2.querySelector('i').classList.contains('bi-eye-slash-fill')) {
            tooltip2._config.title = 'Ocultar contraseña';
            tooltip2.show();
        } else {
            tooltip2._config.title = 'Mostrar contraseña';
            tooltip2.show();
        }
    });

});