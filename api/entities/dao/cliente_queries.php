<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CLIENTE.
*/
class ClienteQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    
    //Consulta para realizar la busqueda de datos en la tabla clientes
    public function searchRows($value)
    {
        $sql = 'SELECT id_cliente, nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, user_cliente
                FROM clientes
                WHERE apellido_cliente ILIKE ? OR nombre_cliente ILIKE ?
                ORDER BY nombre_cliente';
                //Guarda en un array los parametros de busqueda
        $params = array("%$value%", "%$value%");
        //Devuelve los datos buscados
        return Database::getRows($sql, $params);
    }

    //Consulta para crear los datos del cliente
    public function createRow()
    {
        // Se define la consulta SQL para insertar una nueva fila en la tabla 'clientes'.
        $sql = 'INSERT INTO clientes(nombre_cliente, apellido_cliente, dui_cliente, correo_cliente,  telefono_cliente, nacimiento_cliente, direccion_cliente, user_cliente, clave_cliente)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
        // Se definen los parámetros de la consulta SQL utilizando los valores de las propiedades del objeto.
        $params = array($this->nombres, $this->apellidos, $this->dui, $this->correo, $this->telefono, $this->nacimiento, $this->direccion, $this->user, $this->clave);
        // Se ejecuta la consulta utilizando la función 'executeRow' y se retornan los resultados.
        return Database::executeRow($sql, $params);
    }

    //Consulta para leer todos los datos de la tabla clientes
    public function readAll()
    {
        $sql = 'SELECT id_cliente, nombre_cliente, apellido_cliente, telefono_cliente,direccion_cliente,dui_cliente, correo_cliente, estado_cliente
        FROM clientes
        ORDER BY apellido_cliente ASC';
        //Devueve todos los valores de la tabla clientes
        return Database::getRows($sql);
    }
    //Consulta para cargar un dato especifico de la tabla clientes
    public function readOne()
    {
        $sql = 'SELECT id_cliente, nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, user_cliente, estado_cliente 
                FROM clientes
                WHERE id_cliente = ?';
                //Guarda el id del cliente seleccionado
        $params = array($this->id);
        //Devuelve los datos del cliente seleccionado
        return Database::getRow($sql, $params);
    }
    //Actualiza el cliente seleccionado
    public function updateRow()
    {
        $sql = 'UPDATE clientes
                SET nombre_cliente = ?, apellido_cliente = ?, dui_cliente = ?, telefono_cliente = ?, nacimiento_cliente = ?, direccion_cliente = ?, user_cliente = ?, estado_cliente = ?
                WHERE id_cliente = ?';
                //Guarda los nuevos datos del cliente
        $params = array($this->nombres, $this->apellidos, $this->dui, $this->telefono, $this->nacimiento, $this->direccion, $this->user, $this->estado, $this->id);
        //Devuelve los datos del cliente actualizados
        return Database::executeRow($sql, $params);
    }
    //Elimina un cliente en la base de datos
    public function deleteRow()
    {
        $sql = 'DELETE FROM clientes
                WHERE id_cliente = ?';
                //Obtiene el id del cliente seleccionado
        $params = array($this->id);
        //Elimina el cliente
        return Database::executeRow($sql, $params);
    }

    /*
    *   Métodos para gestionar la cuenta del cliente.
    */

    //Consulta para verificar si el usuario cliente esta activo
    public function checkUser($user)
    {
        $sql = 'SELECT id_cliente, estado_cliente FROM clientes WHERE user_cliente = ?';
        $params = array($user);
        //Verifica si el cliente esta activo
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['id_cliente'];
            $this->estado = $data['estado_cliente'];
            $this->user = $user;
            return true;
        } else {
            //Si no esta desactivado
            return false;
        }
    }
    //Consulta para verificar la clave del cliente
    public function checkPassword($password)
    {
        $sql = 'SELECT clave_cliente FROM clientes WHERE id_cliente = ?';
        $params = array($this->id);
        $data = Database::getRow($sql, $params);
        //Si la clave del cliente es igual es correcta
        if (password_verify($password, $data['clave_cliente'])) {
            return true;
        } else {
            //Si no es incorrecta
            return false;
        }
    }
    //Consulta para cambiar contraseña
    public function changePassword()
    {
        $sql = 'UPDATE clientes SET clave_cliente = ? WHERE id_cliente = ?';
        //Obtiene la clave y el id del cliente
        $params = array($this->clave, $this->id);
        //Cambia la contraseña
        return Database::executeRow($sql, $params);
    }
    //Consulta para editar perfil del cliente
    public function editProfile()
    {
        $sql = 'UPDATE clientes
                SET nombre_cliente = ?, apellido_cliente = ?, dui_cliente = ?, correo_cliente = ?, telefono_cliente = ?, nacimiento_cliente = ?, direccion_cliente = ?
                WHERE id_cliente = ?';
                //Obtiene todo los datos nuevos del cliente
        $params = array($this->nombres, $this->apellidos, $this->dui, $this->correo, $this->telefono, $this->nacimiento, $this->direccion, $this->id);
        //Actualiza el perfil del cliente
        return Database::executeRow($sql, $params);
    }
    //Consulta para cambiar el estado del cliente
    public function changeStatus($status)
    {
        ($status) ? $status = 0 : $status = 1;
        $sql = 'UPDATE clientes
                SET estado_cliente = ?
                WHERE id_cliente = ?';
                //Obtiene el id del cliente
        $params = array($status, $this->id);
        //Cambia el estado del cliente
        return Database::executeRow($sql, $params);
    }
}
