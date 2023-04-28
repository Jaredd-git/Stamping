<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class TallaQueries
{
    //Consulta para leer todos lso registros de la tabla tallas
    public function readAll()
    {
        $sql = 'SELECT id_talla, talla
                FROM tallas
                ORDER BY talla';
                //Carga todos los registros de la tabla tallas
        return Database::getRows($sql);
    }
}
