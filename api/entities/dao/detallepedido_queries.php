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

    // Método para agregar un producto al carrito de compras.
    public function createDetail()
    {
        // Consulta para obtener la cantidad disponible del producto en la tabla "productos"
        $sqlQuantityAvailable = 'SELECT existencias FROM productos WHERE id_producto = ?';
        $params = array($this->producto);
        $data = Database::getRow($sqlQuantityAvailable, $params);

        if ($data['existencias'] >= $this->cantidad) {
            // Verificar si la cantidad disponible es suficiente para realizar la inserción en la tabla "detalles_pedidos; Se realiza una subconsulta para obtener el precio del producto.
            $sql = 'INSERT INTO detalles_pedidos(id_producto, precio, cantidad_producto, id_pedido, id_talla)
            VALUES(?, (SELECT precio_producto FROM productos WHERE id_producto = ?), ?, ?, ?)';
            $params = array($this->producto, $this->producto, $this->cantidad, $this->id_pedido, $this->talla);
            if (Database::executeRow($sql, $params)) {
                // Consulta para actualizar la cantidad disponible en la tabla "productos"
                $sqlActualizarCantidad = 'UPDATE productos SET existencias = existencias - ? WHERE id_producto = ?';
                $paramsActualizarCantidad = array($this->cantidad, $this->producto);
                return Database::executeRow($sqlActualizarCantidad, $paramsActualizarCantidad);
            } else {
                return false;
            }
        } else {
            // No hay suficientes productos disponibles, se retorna false
            return false;
        }
    }
}
