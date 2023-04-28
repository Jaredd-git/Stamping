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
        $sql = 'SELECT id_tipo, nombre_tipo
                FROM tipos
                ORDER BY nombre_tipo';
                //Devuelve todos los registros de la tabla tipos
        return Database::getRows($sql);
    }
}
