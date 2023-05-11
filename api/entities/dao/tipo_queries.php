<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class TipoQueries
{
    //Consulta para realizar la busqueda de datos en la tabla usuarios
    public function searchRows($value)
    {
        $sql = 'SELECT id_tipo, nombre_tipo, descripcion_tipo
                FROM tipos
                WHERE nombre_tipo ILIKE ? OR descripcion_tipo ILIKE ?
                ORDER BY nombre_tipo';
                //Guarda en un array los parametros de busqueda
        $params = array("%$value%", "%$value%");
        //Devuelve los datos buscados
        return Database::getRows($sql, $params);
    }
    //Consulta para cargar todos los registros de la tabla tipos
    public function readAll()
    {
        $sql = 'SELECT id_tipo, nombre_tipo, descripcion_tipo
                FROM tipos
                ORDER BY nombre_tipo';
                //Devuelve todos los registros de la tabla tipos
        return Database::getRows($sql);
    }
    //Consulta para crear un nuevo tipo de prenda
    public function createRow()
    {
        $sql = 'INSERT INTO tipos(nombre_tipo, descripcion_tipo)
                VALUES(?, ?)';
                //Obtiene los datos del nuevo tipo 
        $params = array($this->nombre, $this->descripcion);
        //Crea el usuario en la base de datos
        return Database::executeRow($sql, $params);
    }
    //Elimina un usuario en la base de datos
    public function deleteRow()
    {
        $sql = 'DELETE FROM tipos
                WHERE id_tipo = ?';
                //Obtiene el id del tipo de prenda seleccionada
        $params = array($this->id);
        //Elimina el tipo de prenda
        return Database::executeRow($sql, $params);
    }
    //Consulta para cargar un dato especifico de la tabla productos
    public function readOne()
    {
        $sql = 'SELECT id_tipo, nombre_tipo, descripcion_tipo
                FROM tipos
                WHERE id_tipo = ?';
                //Se obtiene el id del producto
        $params = array($this->id);
        //Carga el dato seleccionado
        return Database::getRow($sql, $params);
    }
    //Actualiza unos datos especificos de la tabla productos
    public function updateRow()
    {
        $sql = 'UPDATE tipos
                SET nombre_tipo = ?, descripcion_tipo = ?
                WHERE id_tipo = ?';
                //Obtiene todos los datos para la actualizacion del producto
        $params = array($this->nombre, $this->descripcion, $this->id);
        //Actualiza el producto seleccionado
        return Database::executeRow($sql, $params);
    }
}
