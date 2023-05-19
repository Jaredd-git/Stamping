
const SIGNUP_FORM = document.getElementById('signup-form');

/**
 * Event listener que se ejecuta cuando el DOM ha sido cargado.
 * Se encarga de obtener los elementos necesarios para mostrar/ocultar la contraseña y asignar un evento al botón correspondiente.
 */
document.addEventListener('DOMContentLoaded', () => {
    // reCAPTCHA();
    // Constante tipo objeto para obtener la fecha y hora actual.
    const TODAY = new Date();
    // Se declara e inicializa una variable para guardar el día en formato de 2 dígitos.
    let day = ('0' + TODAY.getDate()).slice(-2);
    // Se declara e inicializa una variable para guardar el mes en formato de 2 dígitos.
    var month = ('0' + (TODAY.getMonth() + 1)).slice(-2);
    // Se declara e inicializa una variable para guardar el año con la mayoría de edad.
    let year = TODAY.getFullYear() - 18;
    // Se declara e inicializa una variable para establecer el formato de la fecha.
    let date = `${year}-${month}-${day}`;
    // Se asigna la fecha como valor máximo en el campo del formulario.
    document.getElementById('nacimiento').max = date;
    const showPasswordButton1 = document.querySelector('#show-password1');
    const showPasswordButton2 = document.querySelector('#show-password2');
    const passwordInput1 = document.querySelector('#clave');
    const passwordInput2 = document.querySelector('#confirmar_clave');

    // Se crea una instancia del tooltip de Bootstrap y se asignan las opciones.
    if (showPasswordButton1) {
        const tooltip1 = new bootstrap.Tooltip(showPasswordButton1, {
            title: 'Mostrar contraseña',
            placement: 'bottom',
            // Retraso para mostrar y ocultar la información
            delay: { show: 0, hide: 1 }
        });
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
    if (showPasswordButton2) {
        const tooltip2 = new bootstrap.Tooltip(showPasswordButton2, {
            title: 'Mostrar contraseña',
            placement: 'bottom',
            // Retraso para mostrar y ocultar la información
            delay: { show: 0, hide: 1 }
        });
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
    }



});

// Método manejador de eventos para cuando se envía el formulario de registrar cliente.
SIGNUP_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SIGNUP_FORM);
    // Petición para registrar un cliente.
    const JSON = await dataFetch(USER_API, 'signup', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        sweetAlert(1, JSON.message, true, 'login.html');
    } else if (JSON.recaptcha) {
        sweetAlert(2, JSON.exception, false, 'index.html');
    } else {
        sweetAlert(2, JSON.exception, false);
        // Se genera un nuevo token cuando ocurre un problema.
        // reCAPTCHA();
    }
});

/*
*   Función para obtener un token del reCAPTCHA y asignarlo al formulario.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
// function reCAPTCHA() {
//     // Método para generar el token del reCAPTCHA.
//     grecaptcha.ready(() => {
//         // Constante para guardar la llave pública del reCAPTCHA.
//         const PUBLIC_KEY = '6LdBzLQUAAAAAJvH-aCUUJgliLOjLcmrHN06RFXT';
//         // Se obtiene un token para la página web mediante la llave pública.
//         grecaptcha.execute(PUBLIC_KEY, { action: 'homepage' }).then((token) => {
//             // Se asigna el valor del token al campo oculto del formulario
//             document.getElementById('g-recaptcha-response').value = token;
//         });
//     });
// }