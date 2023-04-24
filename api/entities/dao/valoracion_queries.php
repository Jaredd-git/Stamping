<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CLIENTE.
*/
class ValoracionQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_valoracion, id_producto, calificacion_producto, comentario_producto, fecha_comentario, estado_comentario
                FROM valoraciones
                WHERE calificacion_producto ILIKE ? 
                ORDER BY calificaion_producto';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_valoracion, id_producto, calificacion_producto, comentario_producto, fecha_comentario, estado_comentario
        FROM valoraciones
        ORDER BY calificacion_producto ASC';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_valoracion, id_producto, calificacion_producto, comentario_producto, fecha_comentario, estado_comentario
                FROM valoraciones
                WHERE id_valoracion = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM valoraciones
                WHERE id_valoracion = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function changeStatus($status)
    {
        ($status) ? $status = 0 : $status = 1;
        $sql = 'UPDATE valoraciones
                SET estado_comentario = ?
                WHERE id_valoracion = ?';
        $params = array($status, $this->id);
        return Database::executeRow($sql, $params);
    }
}
