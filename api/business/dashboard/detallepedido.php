<?php
require_once('../../entities/dto/pedido.php')

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
            case 'readAll':
                if ($result['dataset'] = $pedido->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $pedido->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'readOne':
                if (!$pedido->setIdPedido($_POST['id_pedido'])) {
                    $result['exception'] = 'Pedido incorrecto';
                } elseif ($result['dataset'] = $pedido->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Pedido inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$pedido->setIdPedido($_POST['id'])) {
                    $result['exception'] = 'Pedido incorrecto';
                } elseif (!$pedido->readOne()) {
                    $result['exception'] = 'Pedido inexistente';
                } elseif (!$pedido->setCliente($_POST['nombres'])) {
                    $result['exception'] = 'Cliente incorrecto';
                } elseif (!$pedido->setEstado($_POST['estadop'])) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!$pedido->setFechaPedido($_POST['fechap'])) {
                    $result['exception'] = 'Fecha incorrecta';
                } elseif (!$pedido->setDireccion($_POST['direccionp'])) {
                    $result['exception'] = 'Dirección incorrecta';
                } elseif ($pedido->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Pedido actualizado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$pedido->setIdPedido($_POST['id_pedido'])) {
                    $result['exception'] = 'Pedido incorrecto';
                } elseif (!$pedido->readOne()) {
                    $result['exception'] = 'Pedido inexistente';
                } elseif ($pedido->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Pedido eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'changeStatus':
                    if (!$cliente->setId($_POST['id_cliente'])) {
                        $result['exception'] = 'Cliente incorrecto';
                    } elseif (!$data = $cliente->readOne()) {
                        $result['exception'] = 'Cliente inexistente';
                    } elseif ($cliente->changeStatus($data['estado_cliente'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Estado actualizado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                    break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
            }
        }
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        print(json_encode('Recurso no disponible'));
}
    
