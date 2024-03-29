<?php
require_once('../../entities/dto/cliente.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $cliente = new Cliente;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'recaptcha' => 0, 'message' => null, 'exception' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como cliente para realizar las acciones correspondientes.
    if (isset($_SESSION['id_cliente'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un cliente ha iniciado sesión.
        switch ($_GET['action']) {
            //Acción utilizada para tomar el usuario
            case 'getUser':
                // Se verifica si existe una sesión de usuario activa.
                if (isset($_SESSION['user_cliente'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['user_cliente'];
                // Se muestra una excepción indicando que el nombre de usuario no está definido.
                } else {
                    $result['exception'] = 'Nombre de usuario indefinido';
                }
                break;
            //Acción utilizada para cerrar sesión del usuario
            case 'logOut':
                 // Se cierra la sesión del usuario.
                if (session_destroy()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesión cerrada correctamente';
                // Se muestra una excepción indicando que ocurrió un problema al cerrar la sesión.
                } else {
                    $result['exception'] = 'Ocurrió un problema al cerrar la sesión';
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando el cliente no ha iniciado sesión.
        switch ($_GET['action']) {
            //Acción utilizada para registrar un cliente
            case 'signup':
                // $_POST = Validator::validateForm($_POST);
                // $secretKey = '6LdBzLQUAAAAAL6oP4xpgMao-SmEkmRCpoLBLri-';
                // $ip = $_SERVER['REMOTE_ADDR'];

                // $data = array('secret' => $secretKey, 'response' => $_POST['g-recaptcha-response'], 'remoteip' => $ip);

                // $options = array(
                //     'http' => array('header'  => "Content-type: application/x-www-form-urlencoded\r\n", 'method' => 'POST', 'content' => http_build_query($data)),
                //     'ssl' => array('verify_peer' => false, 'verify_peer_name' => false)
                // );

                // $url = 'https://www.google.com/recaptcha/api/siteverify';
                // $context  = stream_context_create($options);
                // $response = file_get_contents($url, false, $context);
                // $captcha = json_decode($response, true);

                // if (!$captcha['success']) {
                //     $result['recaptcha'] = 1;
                //     $result['exception'] = 'No eres humano';
                // Se validan y asignan los valores de los campos del cliente.
                 if (!$cliente->setNombres($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$cliente->setApellidos($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$cliente->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$cliente->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Dirección incorrecta';
                } elseif (!$cliente->setDUI($_POST['dui'])) {
                    $result['exception'] = 'DUI incorrecto';
                } elseif (!$cliente->setNacimiento($_POST['nacimiento'])) {
                    $result['exception'] = 'Fecha de nacimiento incorrecta';
                } elseif (!$cliente->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Teléfono incorrecto';
                } elseif (!$cliente->setUser($_POST['usuario'])){
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($_POST['clave'] != $_POST['confirmar_clave']) {
                    $result['exception'] = 'Claves diferentes';
                } elseif (!$cliente->setClave($_POST['clave'])) {
                    $result['exception'] = Validator::getPasswordError();
                //Se verifica si se pudo crear el cliente
                } elseif ($cliente->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cuenta registrada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            // Accion para iniciar sesión en el sistema
            case 'login':
                // Se valida el formulario de login
                $_POST = Validator::validateForm($_POST);
                // Se verifica que el usuario proporcionado sea correcto
                if (!$cliente->checkUser($_POST['user'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$cliente->getEstado()) {
                    $result['exception'] = 'La cuenta ha sido desactivada';
                } elseif ($cliente->checkPassword($_POST['pass'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Autenticación correcta';
                    $_SESSION['id_cliente'] = $cliente->getId();
                    $_SESSION['user_cliente'] = $cliente->getUser();
                } else {
                    $result['exception'] = 'Clave incorrecta';
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible fuera de la sesión';
        }
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
