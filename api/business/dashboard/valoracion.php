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
            // Acción para obtener todas las valoraciones registradas.
            case 'readAll':
                // Se lee todo el conjunto de todas las valoraciones
                if ($result['dataset'] = $valoracion->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                    // Se captura el resultado de la base
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                    // Si no hay datos registrado se le informa al usuario
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                // Acción para buscar entre las valoraciones
            case 'search':
                // Se valida el formulario de buscar 
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['status'] = 1;
                    $result['dataset'] = $valoracion->readAll();
                    $result['exception'] = 'Ingrese un valor para buscar';
                    // Si se encuentran coincidencias en la base de datos, se informa al usuario y se muestran en la respuesta 
                } elseif ($result['dataset'] = $valoracion->searchRows($_POST['search'])) {
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
                // Se obtienen los datos de la valoracion seleccionada
            case 'readOne':
                // Se verifica si el id seleccionado es correcto
                if (!$valoracion->setId($_POST['id_valoracion'])) {
                    $result['exception'] = 'Valoracion incorrecta';
                    // Si se encuentra la valoracion se muestra la respuesta
                } elseif ($result['dataset'] = $valoracion->readOne()) {
                    $result['status'] = 1;
                    // Si ocurre una excepción en la base de datos, se captura
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                    // Si la valoracion no existe, se informa al usuario
                } else {
                    $result['exception'] = 'Cliente inexistente';
                }
                break;
                // Accion para eliminar una valoracion
            case 'delete':
                // Se verifica si el id proporcionado es correcto
                if (!$valoracion->setId($_POST['id_valoracion'])) {
                    $result['exception'] = 'Valoracion incorrecta';
                    // Se verifica si el usuario existe
                } elseif (!$valoracion->readOne()) {
                    $result['exception'] = 'Valoracion inexistente';
                    // Si todas las validaciones son correctas se elimina la valoracion
                } elseif ($valoracion->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cliente eliminado correctamente';
                    // Si ocurre un error, se captura la excepcion
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Accion para cambiar estado de la valoracion
            case 'changeStatus':
                // Se verifica si el id proporcionado es correcto
                    if (!$valoracion->setId($_POST['id_valoracion'])) {
                        $result['exception'] = 'Valoracion incorrecta';
                        // Se verifica si la valoracion existe
                    } elseif (!$data = $valoracion->readOne()) {
                        $result['exception'] = 'Valoracion inexistente';
                        // Se verifica si el cambio de estado es correcto y si es asi se actualiza
                    } elseif ($valoracion->changeStatus($data['estado_comentario'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Estado actualizado correctamente';
                        // Si ocurre un error, se captura la excepcion
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
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}

