<?php
require_once('../../entities/dto/pedido.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $pedido = new Pedido;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_admin'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            // Acción para obtener todos los pedidos registrados.
            case 'readAll':
                // Se lee todo el conjunto de datos de pedidos
                if ($result['dataset'] = $pedido->readAll()) {
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
                // Acción para obtener los estados de los pedidos.
            case 'readEstados':
                // Se lee todo el conjunto de datos de pedidos
                if ($result['dataset'] = $pedido->readEstados()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                // Si no hay datos registrados, se informa al usuario
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                // Acción para buscar en la tabla los pedidos registrados
            case 'search':
                 // Se valida el formulario de búsqueda y se comprueba si el usuario ha ingresado un valor de búsqueda
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['status'] = 1;
                    $result['dataset'] = $pedido->readAll();
                    $result['exception'] = 'Ingrese un valor para buscar';
                // Si se encuentran coincidencias en la base de datos, se informa al usuario y se muestran en la respuesta    
                } elseif ($result['dataset'] = $pedido->searchRows($_POST['search'])) {
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
                // Acción para obtener los datos de un pedido seleccionado
            case 'readOne':
                // Se comprueba si se ha ingresado correctamente el ID del pedido
                if (!$pedido->setIdPedido($_POST['id_pedido'])) {
                    $result['exception'] = 'Pedido incorrecto';
                // Si se encuentra el pedido, se muestra en la respuesta
                } elseif ($result['dataset'] = $pedido->readOne()) {
                    $result['status'] = 1;
                // Si ocurre una excepción en la base de datos, se captura
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                // Si el pedido no existe, se informa al usuario
                } else {
                    $result['exception'] = 'Pedido inexistente';
                }
                break;
                // Acción para actualizar un pedido seleccionado
            case 'update':
                // Se valida el formulario de actualización de pedido
                $_POST = Validator::validateForm($_POST);
                // Se comprueba si se ha ingresado correctamente el ID del pedido
                if (!$pedido->setIdPedido($_POST['id_pedido'])) {
                    $result['exception'] = 'Pedido incorrecto';
                // Si el pedido no existe, se informa al usuario
                } elseif (!$pedido->readOne()) {
                    $result['exception'] = 'Pedido inexistente';
                // Se verifica si el nombre del cliente es válido
                } elseif (!$pedido->setCliente($_POST['nombres'])) {
                    $result['exception'] = 'Cliente incorrecto';
                // Se verifica si el estado del pedido es válido
                } elseif (!$pedido->setEstado($_POST['estadop'])) {
                    $result['exception'] = 'Estado incorrecto';
                // Se verifica si la fecha del pedido es válida
                } elseif (!$pedido->setFechaPedido($_POST['fechap'])) {
                    $result['exception'] = 'Fecha incorrecta';
                // Se verifica si la dirección del pedido es válida
                } elseif (!$pedido->setDireccion($_POST['direccionp'])) {
                    $result['exception'] = 'Dirección incorrecta';
                // Si todas las validaciones anteriores son correctas, se actualiza el pedido en la base de datos
                } elseif ($pedido->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Pedido actualizado correctamente';
                // Si se produce algún error al actualizar el pedido, se captura la excepción
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Acción para eliminar un pedido
            case 'delete':
                // Se verifica si el pedido tiene un ID válido
                if (!$pedido->setIdPedido($_POST['id_pedido'])) {
                    $result['exception'] = 'Pedido incorrecto';
                // Se verifica si el pedido existe
                } elseif (!$pedido->readOne()) {
                    $result['exception'] = 'Pedido inexistente';
                // Si todas las validaciones anteriores son correctas, se elimina el pedido de la base de datos
                } elseif ($pedido->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Pedido eliminado correctamente';
                // Si se produce algún error al eliminar el pedido, se captura la excepción
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Acción para cambiar el estado de un pedido
            case 'changeStatus':
                // Se verifica si el ID del cliente es válido
                if (!$pedido->setIdPedido($_POST['id_pedido'])) {
                    $result['exception'] = 'Pedido incorrecto';
                    // Se verifica si el estado del pedido es valido
                } if (!$pedido->setEstado($_POST['estado'])) {
                    $result['exception'] = 'Estado incorrecto';
                    // Se verifica si el pedido existe, si no se informa al usuario
                } elseif (!$data = $pedido->readOne()) {
                    $result['exception'] = 'Pedido inexistente';
                // Si todas las validaciones anteriores son correctas, se actualiza el estado del cliente en la base de datos
                } elseif ($pedido->changeStatus()) {
                    $result['status'] = 1;
                    $result['message'] = 'Estado actualizado correctamente';
                // Si se produce algún error al actualizar el estado del cliente, se captura la excepción
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            //Para graficos
            case 'cantidadPedidosEstado':
                if ($result['dataset'] = $pedido->cantidadPedidosEstado()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
            case 'cantidadPedidosMes':
                if ($result['dataset'] = $pedido->cantidadPedidosMes()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
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

