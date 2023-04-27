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
            case 'readOne':
                // Se comprueba si se ha ingresado correctamente el ID del pedido
                if (!$pedido->setIdDetalle($_POST['id_detalle'])) {
                    $result['exception'] = 'Detalle incorrecto';
                // Si se encuentra el pedido, se muestra en la respuesta
                } elseif ($result['dataset'] = $pedido->readOne()) {
                    $result['status'] = 1;
                // Si ocurre una excepción en la base de datos, se captura
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                // Si el pedido no existe, se informa al usuario
                } else {
                    $result['exception'] = 'Detalle inexistente';
                }
                break;
            case 'update':
                // Se valida el formulario de actualización de pedido
                $_POST = Validator::validateForm($_POST);
                // Se comprueba si se ha ingresado correctamente el ID del pedido
                if (!$pedido->setIdDetalle($_POST['id'])) {
                    $result['exception'] = 'Detalle incorrecto';
                // Si el pedido no existe, se informa al usuario
                } elseif (!$pedido->readOneDp()) {
                    $result['exception'] = 'Detalle inexistente';
                // Se verifica si el nombre del cliente es válido
                } elseif (!$pedido->setIdPedido($_POST['id'])) {
                    $result['exception'] = 'Pedido incorrecto';
                } elseif (!$pedido->setProducto($_POST['producto'])) {
                    $result['exception'] = 'Producto incorrecto';
                // Se verifica si el estado del pedido es válido
                } elseif (!$pedido->setTalla($_POST['talla'])) {
                    $result['exception'] = 'Talla incorrecta';
                // Se verifica si la fecha del pedido es válida
                } elseif (!$pedido->setCantidad($_POST['cantidadp'])) {
                    $result['exception'] = 'Cantidad incorrecta';
                // Se verifica si la dirección del pedido es válida
                } elseif (!$pedido->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                // Si todas las validaciones anteriores son correctas, se actualiza el pedido en la base de datos
                } elseif ($pedido->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Pedido actualizado correctamente';
                // Si se produce algún error al actualizar el pedido, se captura la excepción
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
} else {
    print(json_encode('Recurso no disponible'));
}

    
