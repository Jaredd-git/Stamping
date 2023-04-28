<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad USUARIO.
*/
class UsuarioQueries
{
    /*
    *   Métodos para gestionar la cuenta del usuario.
    */
    //Consulta para verificar si el  esta activo
    public function checkUser($alias)
    {
        $sql = 'SELECT id_usuario FROM usuarios WHERE alias_usuario = ?';
        $params = array($alias);
        //Verifica si el usuario esta activo
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['id_usuario'];
            $this->alias = $alias;
            return true;
        } else {
            //Si no esta desactivado
            return false;
        }
    }
    //Consulta para verificar la clave del usuario
    public function checkPassword($password)
    {
        $sql = 'SELECT clave_usuario FROM usuarios WHERE id_usuario = ?';
        $params = array($this->id);
        $data = Database::getRow($sql, $params);
        // Se verifica si la contraseña coincide con el hash almacenado en la base de datos.
        if ($password == $data['clave_usuario']) {
            return true;
        } else {
            //Si no es incorrecta
            return false;
        }
    }
    //Consulta para cambiar contraseña
    public function changePassword()
    {
        $sql = 'UPDATE usuarios SET clave_usuario = ? WHERE id_usuario = ?';
        //Obtiene la clave y el id del usuario
        $params = array($this->clave, $_SESSION['id_admin']);
        //Cambia la contraseña
        return Database::executeRow($sql, $params);
    }
    //Consulta para ller el perfil del usuario
    public function readProfile()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario
                FROM usuarios
                WHERE id_usuario = ?';
                //Obtiene el id del usuario
        $params = array($_SESSION['id_admin']);
        //Devuelve los datos del usuario
        return Database::getRow($sql, $params);
    }
    //Consulta para editar perfil del usuario
    public function editProfile()
    {
        $sql = 'UPDATE usuarios
                SET nombre_usuario = ?, apellido_usuario = ?, correo_usuario = ?, alias_usuario = ?
                WHERE id_usuario = ?';
                //Obtiene todo los datos nuevos del usuario
        $params = array($this->nombres, $this->apellidos, $this->correo, $this->alias, $_SESSION['id_admin']);
        //Actualiza el perfil del usuario
        return Database::executeRow($sql, $params);
    }

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */

    //Consulta para realizar la busqueda de datos en la tabla usuarios
    public function searchRows($value)
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario
                FROM usuarios
                WHERE apellido_usuario ILIKE ? OR nombre_usuario ILIKE ?
                ORDER BY apellido_usuario';
                //Guarda en un array los parametros de busqueda
        $params = array("%$value%", "%$value%");
        //Devuelve los datos buscados
        return Database::getRows($sql, $params);
    }
    //Consulta para crear un nuevo usuario
    public function createRow()
    {
        $sql = 'INSERT INTO usuarios(nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, clave_usuario)
                VALUES(?, ?, ?, ?, ?)';
                //Obtiene los datos del nuevo usuario 
        $params = array($this->nombres, $this->apellidos, $this->correo, $this->alias, $this->clave);
        //Crea el usuario en la base de datos
        return Database::executeRow($sql, $params);
    }
    //Consulta para leer todos los datos de la tabla usuarios
    public function readAll()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario
                FROM usuarios
                ORDER BY apellido_usuario';
                //Devueve todos los valores de la tabla usuarios
        return Database::getRows($sql);
    }
    //Consulta para cargar un dato especifico de la tabla usuarios 
    public function readOne()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario
                FROM usuarios
                WHERE id_usuario = ?';
                //Guarda el id del usuario seleccionado
        $params = array($this->id);
        //Devuelve los datos del usuario seleccionado
        return Database::getRow($sql, $params);
    }
    //Actualiza el usuario seleccionado
    public function updateRow()
    {
        $sql = 'UPDATE usuarios 
                SET nombre_usuario = ?, apellido_usuario = ?, correo_usuario = ?
                WHERE id_usuario = ?';
                //Guarda los nuevos datos del usuario
        $params = array($this->nombres, $this->apellidos, $this->correo, $this->id);
        //Devuelve los datos del usuario actualizados
        return Database::executeRow($sql, $params);
    }
    //Elimina un usuario en la base de datos
    public function deleteRow()
    {
        $sql = 'DELETE FROM usuarios
                WHERE id_usuario = ?';
                //Obtiene el id del usuario seleccionado
        $params = array($this->id);
        //Elimina el usuario
        return Database::executeRow($sql, $params);
    }
}
