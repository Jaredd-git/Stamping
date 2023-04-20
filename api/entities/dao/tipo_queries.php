<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class TipoQueries
{
    public function readAll()
    {
        $sql = 'SELECT id_tipo, nombre_tipo
                FROM tipos
                ORDER BY nombre_tipo';
        return Database::getRows($sql);
    }
}
