<?php
require_once('../../entities/dto/tipo.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $tipo = new Tipo;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_admin'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            //Accion utilizada para buscar por diferentes campos en la tabla productos
            case 'search':
                // Se valida el formulario de búsqueda y se comprueba si el usuario ha ingresado un valor de búsqueda
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['status'] = 1;
                    $result['dataset'] = $tipo->readAll();
                    $result['exception'] = 'Ingrese un valor para buscar';
                    // Si se encuentran coincidencias en la base de datos, se informa al usuario y se muestran en la respuesta
                } elseif ($result['dataset'] = $tipo->searchRows($_POST['search'])) {
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
            // Accion utilizada para leer los datos de la tabla tipos 
            case 'readAll':
                if ($result['dataset'] = $tipo->readAll()) {
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
                // Accion utilizada para leer los campos del producto seleccionado 
            case 'readOne':
                // Se comprueba si se ha ingresado correctamente el ID del producto
                if (!$tipo->setId($_POST['id'])) {
                    $result['exception'] = 'Tipo incorrecto';
                    // Si se encuentra el producto, se muestra en la respuesta
                } elseif ($result['dataset'] = $tipo->readOne()) {
                    $result['status'] = 1;
                    // Si ocurre una excepción en la base de datos, se captura
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                    // Si el producto no existe, se informa al usuario
                } else {
                    $result['exception'] = 'Producto inexistente';
                }
                break;
                // Accion para crear un nuevo tipo de prenda
            case 'create':
                // Se valida el fromulario de crear tipo
                $_POST = Validator::validateForm($_POST);
                // Se verifica si el nombre es correcto
                if (!$tipo->setNombreTipo($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                    // Se verifica si los apellidos son correctos
                } elseif (!$tipo->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripcion incorrecta';
                    // Si todas la validaciones son correctas se crea el usuario correctamente
                } elseif ($tipo->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Tipo creado correctamente';
                    // Si ocurre un error se captura la excepcion en la base de datos
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Accion para eliminar un tipo de prenda
            case 'delete':
                // Se verifica el usuario no se pueda eliminar a si mismo
                if ($_POST['id_tipo'] == $_SESSION['id_admin']) {
                    $result['exception'] = 'No se puede eliminar a sí mismo';
                    // Se verifica si el id proporcionado es correcto
                } elseif (!$tipo->setId($_POST['id_tipo'])) {
                    $result['exception'] = 'Tipo incorrecto';
                    // Se verifica si el tipo existe
                } elseif (!$tipo->readOne()) {
                    $result['exception'] = 'Tipo inexistente';
                    // Si todas las validaciones son correctas se elimina el usuario
                } elseif ($tipo->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Tipo eliminado correctamente';
                    // Si ocurre un error, se captura la excepcion
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Accion utilizada para actualizar los campos del cliente seleccionado 
            case 'update':
                // Se valida el formulario de actualización de cliente
                $_POST = Validator::validateForm($_POST);
                // Se comprueba si se ha ingresado correctamente el ID del cliente
                if (!$tipo->setId($_POST['id'])) {
                    $result['exception'] = 'Tipo incorrecto';
                    // Si el cliente no existe, se informa al usuario
                } elseif (!$tipo->readOne()) {
                    $result['exception'] = 'Tipo inexistente';
                    // Se verifica si el nombre del cliente es válido
                } elseif (!$tipo->setNombreTipo($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                    // Se verifica si el apellido del cliente es válido
                } elseif (!$tipo->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripcion incorrecta';
                    // Si todas las validaciones anteriores son correctas, se actualiza el pedido en la base de datos
                } elseif ($tipo->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Tipo actualizado correctamente';
                    // Si se produce algún error al actualizar el cliente, se captura la excepción
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
