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
    public function readAll()
    {
        $sql = 'SELECT id_pedido, id_cliente, id_estado, fecha_pedido, direccion_pedido 
        FROM pedidos
        ORDER BY fecha_pedido DESC';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT p.id_pedido, c.nombre_cliente, e.estado, p.fecha_pedido, p.direccion_pedido 
        FROM pedidos p
        JOIN clientes c ON p.id_cliente = c.id_cliente 
        JOIN estados_pedidos e ON p.id_estado = e.id_estado_pedido 
		    WHERE id_pedido = ?';
        $params = array($this->id_pedido);
        return Database::getRow($sql, $params);
    }

    public function changeStatus($status)
    {
        ($status) ? $status = 0 : $status = 1;
        $sql = 'UPDATE clientes
                SET estado_cliente = ?
                WHERE id_cliente = ?';
        $params = array($status, $this->id);
        return Database::executeRow($sql, $params);
    }
}