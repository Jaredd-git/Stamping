<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad PRODUCTO.
*/
class ValoracionQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_valoracion, calificacion_producto, comentario_producto, fecha_comentario, estado_comentario
                FROM valoraciones
                WHERE calificacion_producto ILIKE ? OR fecha_comentario ILIKE ?
                ORDER BY nombre_producto';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO productos(nombre_producto, descripcion_producto, precio_producto, estado_producto, color_producto, id_tipo, id_talla, existencias, imagen_producto, id_usuario)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->descripcion, $this->precio, $this->estado, $this->color, $this->tipo, $this->talla, $this->existencias, $this->imagen, $_SESSION['id_admin']);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_producto, nombre_producto, descripcion_producto, precio_producto, estado_producto, color_producto, id_tipo, id_talla, existencias
        FROM productos INNER JOIN tipos USING(id_tipo)
        INNER JOIN tallas USING(id_talla)
        ORDER BY nombre_producto';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_producto, nombre_producto, descripcion_producto, precio_producto, estado_producto, color_producto, id_tipo, id_talla, existencias
                FROM productos
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE productos
                SET nombre_producto = ?, descripcion_producto = ?, precio_producto = ?, estado_producto = ?, color_producto = ?, id_tipo = ?, id_talla = ?, existencias = ?
                WHERE id_producto = ?';
        $params = array($this->nombre, $this->descripcion, $this->precio, $this->estado, $this->color, $this->tipo, $this->talla, $this->id, $this->id);
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
