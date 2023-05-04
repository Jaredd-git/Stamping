<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de las entidades PEDIDO y DETALLE_PEDIDO.
*/
class DetalleQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    //Consulta para realizar la busqueda de datos en la tabla detalle pedidos
    public function searchRows($value)
    {
        $sql = 'SELECT id_detalle, id_pedido, id_producto, id_talla, cantidad_producto, precio
                FROM detalles_pedidos p
                INNER JOIN productos USING(id_producto)
                INNER JOIN tallas USING(id_talla)
                WHERE id_pedido ILIKE ?';
                //Guarda en un array los parametros de busqueda
        $params = array("%$value%");
        //Devuelve los datos buscados
        return Database::getRows($sql, $params);
    }
    //Consulta para leer todos los datos de la tabla detalle pedidos
    public function readAll()
    {
        $sql = 'SELECT id_detalle, nombre_producto, talla, cantidad_producto, precio
                FROM detalles_pedidos p
                INNER JOIN productos USING(id_producto)
                INNER JOIN tallas USING(id_talla)
                WHERE id_pedido = ?';
                $params = array($this->id_pedido);
                //Devueve todos los valores de la tabla detalle pedidos
        return Database::getRows($sql, $params);
    }
}