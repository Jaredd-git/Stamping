<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class TipoQueries
{
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
        $params = array($this->nombres, $this->descripcion);
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
        $sql = 'SELECT id_tipo nombre_tipo, descripcion_tipo
                FROM tipos
                WHERE id_tipo = ?';
                //Se obtiene el id del producto
        $params = array($this->id);
        //Carga el dato seleccionado
        return Database::getRow($sql, $params);
    }
}
