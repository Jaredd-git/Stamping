<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad PRODUCTO.
*/
class ProductoQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_producto, nombre_producto, descripcion_producto, precio_producto, tipo, estado_producto, color_producto
                FROM productos INNER JOIN tipos USING(id_tipo)
                INNER JOIN tallas USING(id_talla)
                WHERE nombre_producto ILIKE ? OR descripcion_producto ILIKE ?
                ORDER BY nombre_producto';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO productos(nombre_producto, descripcion_producto, precio_producto, estado_producto, color_producto, id_tipo, id_talla)
                VALUES(?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->descripcion, $this->precio, $this->estado, $this->color, $this->tipo, $this->talla,
         $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_producto, nombre_producto, descripcion_producto, precio_producto, color_producto, id_tipo, id_talla
        FROM productos INNER JOIN tipos USING(id_tipo)
        INNER JOIN tallas USING(id_talla)
        ORDER BY nombre_producto';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_producto, nombre_producto, descripcion_producto, precio_producto, id_tipo, id_talla, estado_producto, color_producto
                FROM productos
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE productos
                SET nombre_producto = ?, descripcion_producto = ?, precio_producto = ?, estado_producto = ?, color_producto = ?, id_tipo = ?, id_talla = ?
                WHERE id_producto = ?';
        $params = array($this->nombre, $this->descripcion, $this->precio, $this->estado, $this->color, $this->tipo, $this->talla, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM productos
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
