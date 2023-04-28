<?php
require_once('../../entities/dto/usuario.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $usuario = new Usuario;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_admin'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            // Acción para obtener el usuario de la sesion
            case 'getUser':
                // Se verifica si el usuario de la sesion es correcto
                if (isset($_SESSION['alias_admin'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['alias_admin'];
                    // Si el usuario es incorrecto, se informa al usuario
                } else {
                    $result['exception'] = 'Alias de usuario indefinido';
                }
                break;
                // Acción para cerrar la sesion actual 
            case 'logOut':
                // Se elimina la sesion y devuelve al login
                if (session_destroy()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesión eliminada correctamente';
                    // Si falla el cerrar sesion se le notifica al usuario
                } else {
                    $result['exception'] = 'Ocurrió un problema al cerrar la sesión';
                }
                break;
                // Acción para leer los datos del usuario
            case 'readProfile':
                if ($result['dataset'] = $usuario->readProfile()) {
                    $result['status'] = 1;
                    // Se captura la respuesta de la base
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                    // Si el usuario no existe, se le notifica al usuario
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
                // Acción para editar el perfil del usuario
            case 'editProfile':
                // Se valida el formulario de editar perfil
                $_POST = Validator::validateForm($_POST);
                // Se verifica si los nombres son validos
                if (!$usuario->setNombres($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                    // Se verifica si los apellidos son valido
                } elseif (!$usuario->setApellidos($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                    // Se verifica si el correo es valido
                } elseif (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                    // Se verifica si el alias es valido 
                } elseif (!$usuario->setAlias($_POST['alias'])) {
                    $result['exception'] = 'Alias incorrecto';
                    // Si todas las validaciones son correctas, se edita el perfil correctamente
                } elseif ($usuario->editProfile()) {
                    $result['status'] = 1;
                    $_SESSION['alias_admin'] = $usuario->getAlias();
                    $result['message'] = 'Perfil modificado correctamente';
                    // Si ocurre un error se captura la excepcion de la base de datos
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Acción para cambiar la contraseña del usuario
            case 'changePassword':
                // Se valida el formulario de cambiar contraseña
                $_POST = Validator::validateForm($_POST);
                // Se verifica si el id del usuario es correcto
                if (!$usuario->setId($_SESSION['id_admin'])) {
                    $result['exception'] = 'Usuario incorrecto';
                    // Se verifica si la clave actual es correcta
                } elseif (!$usuario->checkPassword($_POST['actual'])) {
                    $result['exception'] = 'Clave actual incorrecta';
                    // Se verifica si la clave nueva es diferente
                } elseif ($_POST['nueva'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves nuevas diferentes';
                    // Se obtiene la clave nueva y se valida que sea correcta
                } elseif (!$usuario->setClave($_POST['nueva'])) {
                    $result['exception'] = Validator::getPasswordError();
                    // Si todas las validaciones son correctas se cambia la contraseña
                } elseif ($usuario->changePassword()) {
                    $result['status'] = 1;
                    $result['message'] = 'Contraseña cambiada correctamente';
                    // Si ocurre un error se captura la excepcion en la base de datos
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Acción para obtener todos los usuarios registrados.
            case 'readAll':
                // Se lee todo el conjunto de todos los usuarios
                if ($result['dataset'] = $usuario->readAll()) {
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
                // Acción para buscar entre los usuarios
            case 'search':
                // Se valida el formulario de buscar 
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['status'] = 1;
                    $result['dataset'] = $pedido->readAll();
                    $result['exception'] = 'Ingrese un valor para buscar';
                    // Si se encuentran coincidencias en la base de datos, se informa al usuario y se muestran en la respuesta  
                } elseif ($result['dataset'] = $usuario->searchRows($_POST['search'])) {
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
                // Accion para crear un nuevo usuario
            case 'create':
                // Se valida el fromulario de crear usuario
                $_POST = Validator::validateForm($_POST);
                // Se verifica si los nombres son correctos
                if (!$usuario->setNombres($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                    // Se verifica si los apellidos son correctos
                } elseif (!$usuario->setApellidos($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                    // Se verifica si el correo es correctos
                } elseif (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                    // Se verifica si el alias es correcto
                } elseif (!$usuario->setAlias($_POST['alias'])) {
                    $result['exception'] = 'Alias incorrecto';
                    // Se verifica si la clave es correcta
                } elseif ($_POST['clave'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves diferentes';
                    // Se verifica la clave ingresada sea correcta
                } elseif (!$usuario->setClave($_POST['clave'])) {
                    $result['exception'] = Validator::getPasswordError();
                    // Si todas la validaciones son correctas se crea el usuario correctamente
                } elseif ($usuario->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario creado correctamente';
                    // Si ocurre un error se captura la excepcion en la base de datos
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Se obtienen los datos del usuario seleccionado
            case 'readOne':
                // Se verifica si el id seleccionado es correcto
                if (!$usuario->setId($_POST['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                    // Si se encuentra el usuario se muestra la respuesta
                } elseif ($result['dataset'] = $usuario->readOne()) {
                    $result['status'] = 1;
                    // Si ocurre una excepción en la base de datos, se captura
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                    // Si el usuario no existe, se informa al usuario
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
                // Accion para actualizar un usuario
            case 'update':
                // Si valida el formulario de actualizar usuario
                $_POST = Validator::validateForm($_POST);
                // Se verifica el id proporiconado para ver si el usuario es correcto
                if (!$usuario->setId($_POST['id'])) {
                    $result['exception'] = 'Usuario incorrecto';
                    // Se verifica si el usuario existe, si no se informa al usuario
                } elseif (!$usuario->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                    // Se verifica si los nombres son correctos
                } elseif (!$usuario->setNombres($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                    // Si verifica si los apellidos son correctos
                } elseif (!$usuario->setApellidos($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                    // Se verifica si el correo es correcto
                } elseif (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                    // Si todas las valdiaciones son correctas de actualiza el usuario
                } elseif ($usuario->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario modificado correctamente';
                    // Si ocurre un error se captura la excepcion
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Accion para eliminar un usuario
            case 'delete':
                // Se verifica el usuario no se pueda eliminar a si mismo
                if ($_POST['id_usuario'] == $_SESSION['id_admin']) {
                    $result['exception'] = 'No se puede eliminar a sí mismo';
                    // Se verifica si el id proporcionado es correcto
                } elseif (!$usuario->setId($_POST['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                    // Se verifica si el usuario existe
                } elseif (!$usuario->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                    // Si todas las validaciones son correctas se elimina el usuario
                } elseif ($usuario->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario eliminado correctamente';
                    // Si ocurre un error, se captura la excepcion
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
            // Si no se encuentra ninguna acción disponible dentro de la sesión, se muestra un mensaje de error
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando el administrador no ha iniciado sesión.
        switch ($_GET['action']) {
            // Se leen los usuarios que hay en la base de datos
            case 'readUsers':
                // Si hay usuarios en la base se debe de loguear
                if ($usuario->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Debe autenticarse para ingresar';
                    // Si no hay usuarios registrados debe crear un usuario para poder ingresar
                } else {
                    $result['exception'] = 'Debe crear un usuario para comenzar';
                }
                break;
                // Accion de crear usuario 
            case 'signup':
                // Se valida el formulario de crear usuario 
                $_POST = Validator::validateForm($_POST);
                // Se verifican que los nombres sean validos
                if (!$usuario->setNombres($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                    // Se verifican que los apellidos sean validos
                } elseif (!$usuario->setApellidos($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                    // Se verifican que el correo sean valido
                } elseif (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                    // Se verifican que el alias sean valido
                } elseif (!$usuario->setAlias($_POST['usuario'])) {
                    $result['exception'] = 'Alias incorrecto';
                    // Se verifican qque la clave sea correcta 
                } elseif ($_POST['codigo'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves diferentes';
                    // Se verifican que la clave sea correcta con la anterior
                } elseif (!$usuario->setClave($_POST['codigo'])) {
                    $result['exception'] = Validator::getPasswordError();
                    // Si todas las validacion son correctas se crea el usuario
                } elseif ($usuario->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario registrado correctamente';
                    // Si ocurre un erro se captura la excepcion
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Accion para loguearse en el sistema
            case 'login':
                // Se valida el formulario de login 
                $_POST = Validator::validateForm($_POST);
                // Se verifican que el usuario proporcionado sea correcto
                if (!$usuario->checkUser($_POST['user'])) {
                    $result['exception'] = 'Alias incorrecto';
                    // Se verifican las credenciales si son correctas, el usuario ingresa al sistema
                } elseif ($usuario->checkPassword($_POST['pass'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Autenticación correcta';
                    $_SESSION['id_admin'] = $usuario->getId();
                    $_SESSION['alias_admin'] = $usuario->getAlias();
                    // Si la clave el incorrecta se le informa al usuario
                } else {
                    $result['exception'] = 'Clave incorrecta';
                }
                break;
            default:
            // Si no se encuentra ninguna acción disponible dentro de la sesión, se muestra un mensaje de error
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
