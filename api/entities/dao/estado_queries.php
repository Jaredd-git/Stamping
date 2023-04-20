<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class TallaQueries
{
    public function readAll()
    {
        $sql = 'SELECT id_estado, estado
                FROM estado
                ORDER BY talla';
        return Database::getRows($sql);
    }
}
