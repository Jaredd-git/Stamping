<?php
require_once('../../entities/dto/valoracion.php');
session_start();
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se instancia la clase correspondiente.
    $valoracion = new Valoracion;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    
        switch ($_GET['action']) {
            //Accion utilizada para poder leer todos los campos de la tabla productos
            case 'readAllPreview':
                if (!$valoracion->setProducto($_POST['id_producto'])) {
                    $result['exception'] = 'Producto incorrecto';
                    // Si se encuentra el producto, se muestra en la respuesta
                }
                else if ($result['dataset'] = $valoracion->readAllPreview()) {
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
                case 'createRow':
                    // Se valida el fromulario de crear usuario
                    $_POST = Validator::validateForm($_POST);
                    if (!$valoracion->setProducto($_POST['id'])) {
                        $result['exception'] = 'Producto incorrecto';
                    } elseif (!$valoracion->setCalificacion($_POST['calificacion'])) {
                        $result['exception'] = 'Calificacion incorrecto';
                        // Se verifica si el alias es correcto
                    } elseif (!$valoracion->setComentario($_POST['comentario'])) {
                        $result['exception'] = 'Comentario incorrecto';
                    } elseif ($valoracion->createRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Valoracion creada correctamente';
                        // Si ocurre un error se captura la excepcion en la base de datos
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
