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
    public function searchRows($value)
    {
        $sql = 'SELECT id_detalle, id_pedido, id_producto, id_talla, cantidad_producto, precio
                FROM detalles_pedidos p
                INNER JOIN productos USING(id_producto)
                INNER JOIN tallas USING(id_talla)
                WHERE id_pedido ILIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_detalle, id_pedido, id_producto, nombre_producto, id_talla, talla, cantidad_producto, precio
                FROM detalles_pedidos p
                INNER JOIN productos USING(id_producto)
                INNER JOIN tallas USING(id_talla)';
        return Database::getRows($sql);
    }
}