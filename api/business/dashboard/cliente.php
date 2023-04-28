<?php
require_once('../../entities/dto/cliente.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $cliente = new Cliente;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_admin'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'getUser':
                if (isset($_SESSION['alias_admin'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['alias_admin'];
                } else {
                    $result['exception'] = 'Alias de usuario indefinido';
                }
                break;
                //Accion utilizada para poder leer todos los campos de la tabla clientes
            case 'readAll':
                if ($result['dataset'] = $cliente->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                    // Si ocurre una excepción en la base de datos, se captura
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                    // Si no hay datos registrados, se informa al usuario
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                //Accion utilizada para buscar por diferentes campos en la tabla clientes
            case 'search':
                // Se valida el formulario de búsqueda y se comprueba si el usuario ha ingresado un valor de búsqueda
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['status'] = 1;
                    $result['dataset'] = $cliente->readAll();
                    $result['exception'] = 'Ingrese un valor para buscar';
                    // Si se encuentran coincidencias en la base de datos, se informa al usuario y se muestran en la respuesta  
                } elseif ($result['dataset'] = $cliente->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                    // Si ocurre una excepción en la base de datos, se captura 
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                    // Si no hay coincidencias, se informa al usuario
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
                // Accion utilizada para leer los campos del cliente seleccionado 
            case 'readOne':
                // Se comprueba si se ha ingresado correctamente el ID del cliente
                if (!$cliente->setId($_POST['id_cliente'])) {
                    $result['exception'] = 'Cliente incorrecto';
                    // Si se encuentra el cliente, se muestra en la respuesta
                } elseif ($result['dataset'] = $cliente->readOne()) {
                    $result['status'] = 1;
                    // Si ocurre una excepción en la base de datos, se captura
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                    // Si el cliente no existe, se informa al usuario
                } else {
                    $result['exception'] = 'Cliente inexistente';
                }
                break;
                // Accion utilizada para actualizar los campos del cliente seleccionado 
            case 'update':
                // Se valida el formulario de actualización de cliente
                $_POST = Validator::validateForm($_POST);
                // Se comprueba si se ha ingresado correctamente el ID del cliente
                if (!$cliente->setId($_POST['id'])) {
                    $result['exception'] = 'Cliente incorrecto';
                    // Si el cliente no existe, se informa al usuario
                } elseif (!$cliente->readOne()) {
                    $result['exception'] = 'Cliente inexistente';
                    // Se verifica si el nombre del cliente es válido
                } elseif (!$cliente->setNombres($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                    // Se verifica si el apellido del cliente es válido
                } elseif (!$cliente->setApellidos($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                    // Se verifica si el DUI del cliente es valido
                } elseif (!$cliente->setDUI($_POST['DUI'])) {
                    $result['exception'] = 'DUI incorrecto';
                    // Se verifica si el correo del cliente es válido
                } elseif (!$cliente->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                    // Se verifica si el telefono del cliente es válido
                } elseif (!$cliente->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Teléfono incorrecto';
                    // Se verifica si el nacimiento del cliente es válido
                } elseif (!$cliente->setNacimiento($_POST['nacimiento'])) {
                    $result['exception'] = 'Nacimiento incorrecto';
                    // Se verifica si la direccion del cliente es válida
                } elseif (!$cliente->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Dirección incorrecta';
                    // Se verifica si el usuario del cliente es valido
                } elseif (!$cliente->setUser($_POST['user'])) {
                    $result['exception'] = 'Usuario incorrecto';
                    // Si todas las validaciones anteriores son correctas, se actualiza el pedido en la base de datos
                } elseif ($cliente->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cliente actualizado correctamente';
                    // Si se produce algún error al actualizar el cliente, se captura la excepción
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                // Se verifica si el cliente tiene un ID válido
                if (!$cliente->setId($_POST['id_cliente'])) {
                    $result['exception'] = 'Cliente incorrecto';
                    // Se verifica si el cliente existe
                } elseif (!$cliente->readOne()) {
                    $result['exception'] = 'Cliente inexistente';
                    // Si todas las validaciones anteriores son correctas, se elimina el cliente de la base de datos
                } elseif ($cliente->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cliente eliminado correctamente';
                    // Si se produce algún error al eliminar el cliente, se captura la excepción
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'changeStatus':
                // Se verifica si el ID del cliente es válido
                    if (!$cliente->setId($_POST['id_cliente'])) {
                        $result['exception'] = 'Cliente incorrecto';
                        // Se verifica si el cliente existe
                    } elseif (!$data = $cliente->readOne()) {
                        $result['exception'] = 'Cliente inexistente';
                        // Si todas las validaciones anteriores son correctas, se actualiza el estado del cliente en la base de datos
                    } elseif ($cliente->changeStatus($data['estado_cliente'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Estado actualizado correctamente';
                        // Si se produce algún error al actualizar el estado del cliente, se captura la excepción
                    } else {
                        $result['exception'] = Database::getException();
                    }
                    break;
            default:
             // Si no se encuentra ninguna acción disponible dentro de la sesión, se muestra un mensaje de error
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        print(json_encode('Recurso no disponible'));
    }
}
