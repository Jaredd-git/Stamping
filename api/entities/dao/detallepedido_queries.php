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
        $sql = 'SELECT id_pedido, id_cliente, id_estado, fecha_pedido, direccion_pedido
                FROM pedidos
                WHERE direccion_pedido ILIKE ?
                ORDER BY fecha_pedido DESC';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_pedido, id_cliente, id_estado, fecha_pedido, direccion_pedido 
        FROM pedidos
        ORDER BY fecha_pedido DESC';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_pedido, id_cliente, id_estado, fecha_pedido, direccion_pedido 
            FROM pedidos
		    WHERE id_pedido = ?';
        $params = array($this->id_pedido);
        return Database::getRow($sql, $params);
    }

    public function readOneDp()
    {
        $sql = 'SELECT id_detalle, id_pedido, id_producto, id_talla, cantidad_producto, precio_producto 
            FROM detalles_pedidos
		    WHERE id_detalle = ?';
        $params = array($this->id_detalle);
        return Database::getRow($sql, $params);
    }

    public function changeStatus($status)
    {
        ($status) ? $status = 0 : $status = 1;
        $sql = 'UPDATE clientes
                SET estado_cliente = ?
                WHERE id_cliente = ?';
        $params = array($status, $this->id_pedido);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE pedidos
                SET id_cliente = ?, id_estado = ?, fecha_pedido = ?, direccion_pedido
                WHERE id_pedido = ?';
        $params = array($this->id_cliente, $this->id_estado, $this->fecha_pedido, $this->direccion_pedido, $this->id_pedido);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM pedidos
                WHERE id_pedido = ?';
        $params = array($this->id_pedido);
        return Database::executeRow($sql, $params);
    }
}