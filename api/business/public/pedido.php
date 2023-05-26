<?php
require_once('../../entities/dto/pedido.php');
require_once('../../entities/dto/detallepedido.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $pedido = new Pedido;
    $detalle = new Detalle;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como cliente para realizar las acciones correspondientes.
    if (isset($_SESSION['id_cliente'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un cliente ha iniciado sesión.
        switch ($_GET['action']) {
            //Accion utilizada para crear el detalle
            case 'createDetail':
                $_POST = Validator::validateForm($_POST);
                // Se verifica si no se pudo iniciar el pedido.
                if (!$pedido->startOrder()) {
                    $result['exception'] = Database::getException();
                // Se verifica si no se pudo establecer el ID del pedido en el detalle.
                } elseif (!$detalle->setIdPedido($pedido->getIdPedido())) {
                    $result['exception'] = 'Pedido incorrecto';
                // Se verifica si no se pudo establecer el ID del producto en el detalle.
                } elseif (!$detalle->setProducto($_POST['id_producto'])) {
                    $result['exception'] = 'Producto incorrecto';
                // Se verifica si no se pudo establecer la cantidad en el detalle.
                } elseif (!$detalle->setCantidad($_POST['cantidad'])) {
                    $result['exception'] = 'Cantidad incorrecta';
                // Se verifica si no se seleccionó una talla.
                } elseif (!isset($_POST['talla'])) {
                    $result['exception'] = 'Seleccione una talla';
                // Se verifica si no se pudo establecer la talla en el detalle.
                } elseif (!$detalle->setTalla($_POST['talla'])) {
                    $result['exception'] = 'Talla incorrecta';
                // Se verifica si se pudo crear el detalle correctamente.
                } elseif ($detalle->createDetail()) {
                    $result['status'] = 1;
                    $result['message'] = 'Producto agregado correctamente';
                //Se muestra una excepción si ocurre un error
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            //Accion utilizada para leer el detalle
            case 'readOrderDetail':
                // Se verifica si no se pudo iniciar el pedido.
                if (!$pedido->startOrder()) {
                    $result['exception'] = 'Debe agregar un producto al carrito';
                }
                // Se verifica si se pudo leer el detalle del pedido correctamente.
                elseif ($result['dataset'] = $pedido->readOrderDetail()) {
                    $result['status'] = 1;
                    $_SESSION['id_pedido'] = $pedido->getIdPedido();
                }
                // Se muestra una excepción si ocurre un error.
                elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                }
                // Se muestra un mensaje indicando que no hay productos en el carrito.
                else {
                    $result['exception'] = 'No tiene productos en el carrito';
                }
                break;
            //Accion utilizada para actualizar el detalle
            case 'updateDetail':
                // Se validan los datos recibidos en $_POST.
                $_POST = Validator::validateForm($_POST);
                // Se verifica si no se pudo establecer el ID del detalle.
                if (!$detalle->setIdDetalle($_POST['id_detalle'])) {
                    $result['exception'] = 'Detalle incorrecto';
                }
                // Se verifica si no se pudo establecer la cantidad en el detalle.
                elseif (!$detalle->setCantidad($_POST['cantidad'])) {
                    $result['exception'] = 'Cantidad incorrecta';
                }
                // Se verifica si se pudo actualizar el detalle correctamente.
                elseif ($detalle->updateDetail()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cantidad modificada correctamente';
                }
                // Se muestra una excepción de la cantidad si no se puede actualizar.
                else {
                    $result['exception'] = 'Ocurrió un problema al modificar la cantidad';
                }
                break;
            //Accion utilizada para eliminar el detalle
            case 'deleteDetail':
                // Se verifica si no se pudo establecer el ID del detalle.
                if (!$detalle->setIdDetalle($_POST['id_detalle'])) {
                    $result['exception'] = 'Detalle incorrecto';
                }
                // Se verifica si se pudo eliminar el detalle correctamente.
                elseif ($detalle->deleteDetail()) {
                    $result['status'] = 1;
                    $result['message'] = 'Producto removido correctamente';
                }
                // Se muestra una excepción, si no se pudo remover el producto.
                else {
                    $result['exception'] = 'Ocurrió un problema al remover el producto';
                }
                break;
            //Acción utilizada para finalizar la orden
            case 'finishOrder':
                // Se verifica si se pudo finalizar el pedido correctamente.
                if ($pedido->finishOrder()) {
                    $result['status'] = 1;
                    $result['message'] = 'Pedido finalizado correctamente';
                }
                // Se muestra una excepción, si existe un problema para finalizar el pedido.
                else {
                    $result['exception'] = 'Ocurrió un problema al finalizar el pedido';
                }
                break;
            //Acción utiliada para leer los pedidos del cliente
            case 'readAll':
                if ($result['dataset'] = $pedido->readAllPedido()) {
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
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
            }
    } else {
        // Se compara la acción a realizar cuando un cliente no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'createDetail':
                $result['exception'] = 'Debe iniciar sesión para agregar el producto al carrito';
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
