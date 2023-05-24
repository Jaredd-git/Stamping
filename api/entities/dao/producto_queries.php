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
    //Consulta para realizar la busqueda de datos en la tabla productos
    public function searchRows($value)
    {
        $sql = 'SELECT id_producto, nombre_producto, descripcion_producto, precio_producto, id_tipo, estado_producto, color_producto, existencias
                FROM productos INNER JOIN tipos USING(id_tipo)
                WHERE nombre_producto ILIKE ? OR descripcion_producto ILIKE ?
                ORDER BY nombre_producto';
                //Guarda en un array los parametros de busqueda
        $params = array("%$value%", "%$value%");
        //Devuelve los datos buscados
        return Database::getRows($sql, $params);
    }

    //Consulta para crear un nuevo producto
    public function createRow()
    {
        $sql = 'INSERT INTO productos(nombre_producto, descripcion_producto, precio_producto, estado_producto, color_producto, id_tipo, id_talla_p, existencias, imagen_producto, id_usuario)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
                //Se obtienen todos los parametros para el nuevo producto
        $params = array($this->nombre, $this->descripcion, $this->precio, $this->estado, $this->color, $this->tipo, $this->talla, $this->existencias, $this->imagen, $_SESSION['id_admin']);
        //Crea el nuevo producto
        return Database::executeRow($sql, $params);
    }

    //Consulta para leer todos los datos de la tabla productos
    public function readAll()
    {
        $sql = 'SELECT id_producto, nombre_producto, descripcion_producto, precio_producto, imagen_producto, estado_producto, color_producto, id_tipo, existencias
        FROM productos INNER JOIN tipos USING(id_tipo)
        ORDER BY nombre_producto';
        //Muestra todos los datos de la tabla productos
        return Database::getRows($sql);
    }

    public function readAllPreview()
    {
        $sql = 'SELECT id_producto, nombre_producto, descripcion_producto, precio_producto, imagen_producto
        FROM productos
        ORDER BY nombre_producto';
        //Muestra todos los datos de la tabla productos
        return Database::getRows($sql);
    }

    //Consulta para cargar un dato especifico de la tabla productos
    public function readOne()
    {
        $sql = 'SELECT id_producto, nombre_producto, descripcion_producto, precio_producto, imagen_producto, estado_producto, color_producto, id_tipo, id_talla_p, existencias
                FROM productos
                WHERE id_producto = ?';
                //Se obtiene el id del producto
        $params = array($this->id);
        //Carga el dato seleccionado
        return Database::getRow($sql, $params);
    }

    //Actualiza unos datos especificos de la tabla productos
    public function updateRow($current_image)
    {
        //Se valida la actualizacion de la imagen
        ($this->imagen) ? Validator::deleteFile($this->getRuta(), $current_image) : $this->imagen = $current_image;
        $sql = 'UPDATE productos
                SET nombre_producto = ?, descripcion_producto = ?, precio_producto = ?, imagen_producto = ?,estado_producto = ?, color_producto = ?, id_tipo = ?, id_talla_p = ?, existencias = ?
                WHERE id_producto = ?';
                //Obtiene todos los datos para la actualizacion del producto
        $params = array($this->nombre, $this->descripcion, $this->precio, $this->imagen,$this->estado, $this->color, $this->tipo, $this->talla, $this->existencias, $this->id);
        //Actualiza el producto seleccionado
        return Database::executeRow($sql, $params);
    }

    //Consulta para cambiar las existencias de un producto
    public function changeStock()
    {
        $sql = 'UPDATE productos
                SET existencias = ?
                WHERE id_producto = ?';
        $params = array($_POST['existencias'], $this->id);
        return Database::executeRow($sql, $params);
    }

    //Consulta para eliminar un campo desconocido
    public function deleteRow()
    {
        $sql = 'DELETE FROM productos
                WHERE id_producto = ?';
                //Se obtiene el id del producto
        $params = array($this->id);
        //Se elimina el registro seleccionado
        return Database::executeRow($sql, $params);
    }
}
