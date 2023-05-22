<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de las entidades PEDIDO y DETALLE_PEDIDO.
*/
class PedidoQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    // Método para verificar si existe un pedido en proceso para seguir comprando, de lo contrario se crea uno.
    public function startOrder()
    {
        $sql = 'SELECT id_pedido
                FROM pedidos
                WHERE estado_pedido = 3 AND id_cliente = ?';
        $params = array($_SESSION['id_cliente']);
        if ($data = Database::getRow($sql, $params)) {
            $this->id_pedido = $data['id_pedido'];
            return true;
        } else {
            $sql = 'INSERT INTO pedidos(direccion_pedido, id_cliente)
                    VALUES((SELECT direccion_cliente FROM clientes WHERE id_cliente = ?), ?)';
            $params = array($_SESSION['id_cliente'], $_SESSION['id_cliente']);
            // Se obtiene el ultimo valor insertado en la llave primaria de la tabla pedidos.
            if ($this->id_pedido = Database::getLastRow($sql, $params)) {
                return true;
            } else {
                return false;
            }
        }
    }

    // Método para agregar un producto al carrito de compras.
    public function createDetail()
    {
        // Consulta para obtener la cantidad disponible del producto en la tabla "productos"
        $sqlQuantityAvailable = 'SELECT existencias FROM productos WHERE id_producto = ?';
        $params = array($this->producto);
        $quantityAvailable = = Database::getScalar($sqlQuantityAvailable, $params);

        if ($quantityAvailable >= $this->cantidad) {
            // Verificar si la cantidad disponible es suficiente para realizar la inserción en la tabla "detalles_pedidos; Se realiza una subconsulta para obtener el precio del producto.
            $sql = 'INSERT INTO detalles_pedidos(id_producto, precio, cantidad_producto, id_pedido)
            VALUES(?, (SELECT precio_producto FROM productos WHERE id_producto = ?), ?, ?)';
            $params = array($this->producto, $this->producto, $this->cantidad, $this->id_pedido);
            return Database::executeRow($sql, $params);

            // Consulta para actualizar la cantidad disponible en la tabla "productos"
            $sqlActualizarCantidad = 'UPDATE productos SET existencias = existencias - ? WHERE id_producto = ?';
            $paramsActualizarCantidad = array($this->cantidad, $this->producto);
            Database::executeRow($sqlActualizarCantidad, $paramsActualizarCantidad);

            // Si hay suficientes productos disponibles y se realizó la inserción, se retorna true
            return true;
    } else {
        // No hay suficientes productos disponibles, se retorna false
        return false;
    }
}

    // Método para obtener los productos que se encuentran en el carrito de compras.
    public function readOrderDetail()
    {
        $sql = 'SELECT id_detalle, nombre_producto, detalle_pedido.precio, detalle_pedido.cantidad_producto
                FROM pedidos INNER JOIN detalles_pedidos USING(id_pedido) INNER JOIN productos USING(id_producto)
                WHERE id_pedido = ?';
        $params = array($this->id_pedido);
        return Database::getRows($sql, $params);
    }

    // Método para finalizar un pedido por parte del cliente.
    public function finishOrder()
    {
        // Se establece la zona horaria local para obtener la fecha del servidor.
        date_default_timezone_set('America/El_Salvador');
        $date = date('Y-m-d');
        $this->estado = 1;
        $sql = 'UPDATE pedidos
                SET id_estado = ?, fecha_pedido = ?
                WHERE id_pedido = ?';
        $params = array($this->estado, $date, $_SESSION['id_pedido']);
        return Database::executeRow($sql, $params);
    }

    // Método para actualizar la cantidad de un producto agregado al carrito de compras.
    public function updateDetail()
    {
        // Obtener la cantidad disponible del producto
        $sqlStockAvailable = 'SELECT existencias FROM productos p
        INNER JOIN detalles_pedidos dp ON p.id_producto = dp.id_producto
        WHERE dp.id_detalle = ? AND dp.id_pedido = ?';
        $params = array($this->id_detalle, $_SESSION['id_pedido']);
        $cantidadDisponible = Database::getScalar($sqlStockAvailable, $params);

        // Verificar si la cantidad disponible es suficiente
        if ($cantidadDisponible >= $this->cantidad) {
            // Actualizar la cantidad en la tabla detalles_pedidos
            $sql = 'UPDATE detalles_pedidos
                    SET cantidad_producto = ?
                    WHERE id_detalle = ? AND id_pedido = ?';
            $params = array($this->cantidad, $this->id_detalle, $_SESSION['id_pedido']);
            Database::executeRow($sql, $params);

            // Actualizar la cantidad disponible en la tabla productos
            $sqlUpdateStock = 'UPDATE productos p
                                SET existencias = p.existencias - dp.cantidad_producto
                                FROM detalles_pedidos dp
                                WHERE p.id_producto = dp.id_producto
                                    AND dp.id_detalle = ?
                                    AND dp.id_pedido = ?';
            $params = array($this->cantidad, $this->id_detalle, $_SESSION['id_pedido']);
            Database::executeRow($sqlUpdateStock, $params);

            // Si hay suficientes productos disponibles y se realizó la actualización, se retorna true
            return true;
        } else {
            // No hay suficientes productos disponibles, se retorna false
            return false;
        }
    }

    // Método para eliminar un producto que se encuentra en el carrito de compras.
    public function deleteDetail()
    {
        $sql = 'DELETE FROM detalles_pedidos
                WHERE id_detalle = ? AND id_pedido = ?';
        $params = array($this->id_detalle, $_SESSION['id_pedido']);
        return Database::executeRow($sql, $params);
    }

    // Método para obtener los estados de los pedidos.
    public function readEstados()
    {
        $sql = 'SELECT id_estado_pedido, estado
                FROM estados_pedidos';
        return Database::getRows($sql);
    }

    // Método para obtener todos los pedidos registrados.
    public function readAll()
    {
        $sql = "SELECT id_pedido, CONCAT(nombre_cliente,' ', apellido_cliente) cliente, id_estado, estado, fecha_pedido, direccion_pedido
                FROM pedidos p
                INNER JOIN clientes USING(id_cliente)
                INNER JOIN estados_pedidos ep ON ep.id_estado_pedido = p.id_estado
                ORDER BY id_pedido";
        return Database::getRows($sql);
    }

    // Método para obtener los datos de un pedido.
    public function readOne()
    {
        $sql = "SELECT id_pedido, CONCAT(nombre_cliente,' ', apellido_cliente) cliente, id_estado, estado, fecha_pedido, direccion_pedido
                FROM pedidos p
                INNER JOIN clientes USING(id_cliente)
                INNER JOIN estados_pedidos ep ON ep.id_estado_pedido = p.id_estado
		        WHERE id_pedido = ?";
        $params = array($this->id_pedido);
        return Database::getRow($sql, $params);
    }
    
    // Método para cambiar el estado de un pedido
    public function changeStatus()
    {
        $sql = 'UPDATE pedidos
                SET id_estado = ?
                WHERE id_pedido = ?';
        $params = array($this->id_estado, $this->id_pedido);
        return Database::executeRow($sql, $params);
    }

    public function searchRows($value)
    {
        $sql = "SELECT id_pedido, CONCAT(nombre_cliente,' ', apellido_cliente) cliente, id_estado, estado, fecha_pedido, direccion_pedido
                FROM pedidos p
                INNER JOIN clientes USING(id_cliente)
                INNER JOIN estados_pedidos ep ON ep.id_estado_pedido = p.id_estado
                WHERE direccion_pedido ILIKE ?";
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }
}
