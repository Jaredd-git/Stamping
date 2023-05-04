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
}
