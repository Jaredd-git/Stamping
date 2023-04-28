<?php
require_once('../../entities/dto/producto.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $producto = new Producto;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_admin'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            //Accion utilizada para poder leer todos los campos de la tabla productos
            case 'readAll':
                if ($result['dataset'] = $producto->readAll()) {
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
                //Accion utilizada para buscar por diferentes campos en la tabla productos
            case 'search':
                // Se valida el formulario de búsqueda y se comprueba si el usuario ha ingresado un valor de búsqueda
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['status'] = 1;
                    $result['dataset'] = $producto->readAll();
                    $result['exception'] = 'Ingrese un valor para buscar';
                    // Si se encuentran coincidencias en la base de datos, se informa al usuario y se muestran en la respuesta
                } elseif ($result['dataset'] = $producto->searchRows($_POST['search'])) {
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
                // Accion utilizada para crear un producto en la base de datos
            case 'create':
                // Se valida el formulario de crear producto
                $_POST = Validator::validateForm($_POST);
                // Se verifica si el nombre del producto es válido
                if (!$producto->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                    // Se verifica si la descripcion del producto es válido
                } elseif (!$producto->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                    // Se verifica si el precio del producto es válido
                } elseif (!$producto->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                    // Se carga el combo box y se le da un valor predeterminado
                } elseif (!isset($_POST['tipo'])) {
                    $result['exception'] = 'Seleccione un tipo';
                    // Se verifica si el tipo del producto es válido
                } elseif (!$producto->setTipo($_POST['tipo'])) {
                    $result['exception'] = 'Tipo incorrecto';
                    // Se carga el combo box y se le da un valor predeterminado
                } elseif (!isset($_POST['talla'])) {
                    $result['exception'] = 'Seleccione una talla';
                    // Se verifica si la talla del producto es válida
                } elseif (!$producto->setTalla($_POST['talla'])) {
                    $result['exception'] = 'Talla incorrecta';
                    // Se le da valor al switch y un valor predeterminado, se verifica si el estado es valido
                }  elseif (!$producto->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                    // Se verifica si las existencias del producto son válidas
                } elseif (!$producto->setExistencias($_POST['existencias'])) {
                    $result['exception'] = 'Existencias incorrectas';
                    // Se verifica si el color del producto es válido
                } elseif (!$producto->setColor($_POST['color'])) {
                    $result['exception'] = 'Color incorrecto';
                    // Se establece el valor del boton de cargar imagen
                } elseif (!is_uploaded_file($_FILES['imagen']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                    // Se verifica si la imagen subida es valida
                } elseif (!$producto->setImagen($_FILES['imagen'])) {
                    $result['exception'] = Validator::getFileError();
                    // Si todas las validaciones anteriores son correctas, se crea el producto en la base de datos
                } elseif ($producto->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Producto creado correctamente';
                    // Si se produce algún error al crear el producto, se captura la excepción
                    } else {
                        $result['exception'] = Database::getException();
                    }
                break;
                // Accion utilizada para leer los campos del producto seleccionado 
            case 'readOne':
                // Se comprueba si se ha ingresado correctamente el ID del producto
                if (!$producto->setId($_POST['id'])) {
                    $result['exception'] = 'Producto incorrecto';
                    // Si se encuentra el producto, se muestra en la respuesta
                } elseif ($result['dataset'] = $producto->readOne()) {
                    $result['status'] = 1;
                    // Si ocurre una excepción en la base de datos, se captura
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                    // Si el producto no existe, se informa al usuario
                } else {
                    $result['exception'] = 'Producto inexistente';
                }
                break;
                // Accion utilizada para actualizar los campos del producto seleccionado 
            case 'update':
                // Se valida el formulario de actualización de producto
                $_POST = Validator::validateForm($_POST);
                // Se comprueba si se ha ingresado correctamente el ID del producto
                if (!$producto->setId($_POST['id'])) {
                    $result['exception'] = 'Producto incorrecto';
                    // Si el producto no existe, se informa al usuario
                } elseif (!$data = $producto->readOne()) {
                    $result['exception'] = 'Producto inexistente';
                    // Se verifica si el nombre del producto es válido
                } elseif (!$producto->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                    // Se verifica que el color del producto es válido
                } elseif (!$producto->setColor($_POST['color'])) {
                    $result['exception'] = 'Color incorrecto';
                    // Se verifica si la descripcion del producto es válida
                } elseif (!$producto->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                    // Se verifica si el precio del producto es válido
                } elseif (!$producto->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                    // Se verifica si el tipo del producto es válido
                } elseif (!$producto->setTipo($_POST['tipo'])) {
                    $result['exception'] = 'Tipo incorrecto';
                    // Se verifica si el estado del producto es válido
                } elseif (!$producto->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                    // Se verifica la talla del producto es válido
                } elseif (!$producto->setTalla($_POST['talla'])) {
                    $result['exception'] = 'Talla incorrecta';
                    // Se verifica si las existencias del producto es válido
                } elseif (!$producto->setExistencias($_POST['existencias'])) {
                    $result['exception'] = 'Existencias incorrectas';
                    // Si todas las validaciones anteriores son correctas, se actualiza el producto en la base de datos
                } elseif ($producto->updateRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Producto modificado correctamente';
                        // Si se produce algún error al actualizar el producto, se captura la excepción
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Accion utilizada para eliminar un campo seleccionado de la tabla productos
            case 'delete':
                // Se verifica si el producto tiene un ID válido
                if (!$producto->setId($_POST['id'])) {
                    $result['exception'] = 'Producto incorrecto';
                    // Se verifica si el producto existe
                } elseif (!$data = $producto->readOne()) {
                    $result['exception'] = 'Producto inexistente';
                    // Si todas las validaciones anteriores son correctas, se elimina el producto en la base de datos
                } elseif ($producto->deleteRow()) {
                    $result['status'] = 1;
                        $result['message'] = 'Producto eliminado correctamente';
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
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}
