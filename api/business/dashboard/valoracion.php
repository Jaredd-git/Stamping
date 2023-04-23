<?php
require_once('../../entities/dto/valoracion.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $valoracion = new Valoracion;
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
            case 'readAll':
                if ($result['dataset'] = $valoracion->readAll()) {
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
                } elseif ($result['dataset'] = $valoracion->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'readOne':
                if (!$valoracion->setId($_POST['id_valoracion'])) {
                    $result['exception'] = 'Valoracion incorrecta';
                } elseif ($result['dataset'] = $valoracion->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Valoracion inexistente';
                }
                break;
            case 'delete':
                if (!$valoracion->setId($_POST['id_valoracion'])) {
                    $result['exception'] = 'Valoracion incorrecta';
                } elseif (!$valoracion->readOne()) {
                    $result['exception'] = 'Valoracion inexistente';
                } elseif ($valoracion->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Valoracion eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'changeStatus':
                    if (!$valoracion->setId($_POST['id_valoracion'])) {
                        $result['exception'] = 'Valoracion incorrecta';
                    } elseif (!$data = $valoracion->readOne()) {
                        $result['exception'] = 'Valoracion inexistente';
                    } elseif ($valoracion->changeStatus($data['estado_comentario'])) {
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
