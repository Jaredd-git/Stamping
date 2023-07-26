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
    //Consulta para realizar la busqueda de datos en la tabla valoraciones
    public function searchRows($value)
    {
        $sql = 'SELECT id_valoracion, id_producto, calificacion_producto, comentario_producto, fecha_comentario, estado_comentario
                FROM valoraciones
                WHERE comentario_producto ILIKE ?
                ORDER BY fecha_comentario ASC';
                //Guarda en un array los parametros de busqueda
        $params = array("%$value%");
        //Devuelve los datos buscados
        return Database::getRows($sql, $params);
    }

    //Consulta para crear un nuevo producto
    public function createRow()
    {
        $sql = 'INSERT INTO valoraciones(id_producto, id_cliente, calificacion_producto, comentario_producto)
                VALUES(?, ?, ?, ?)';
                //Se obtienen todos los parametros para el nuevo producto
        $params = array($this->producto, $_SESSION['id_cliente'], $this->calificacion, $this->comentario);
        //Crea el nuevo producto
        return Database::executeRow($sql, $params);
    }

    //Consulta para leer todos los datos de la tabla valoraciones
    public function readAll()
    {
        $sql = 'SELECT id_valoracion, id_producto, nombre_producto, calificacion_producto, comentario_producto, fecha_comentario, estado_comentario
        FROM valoraciones INNER JOIN productos USING(id_producto)
        ORDER BY calificacion_producto ASC';
        //Devueve todos los valores de la tabla valoraciones
        return Database::getRows($sql);
    }

    public function readAllPreview()
    {
        $sql = "SELECT id_valoracion, id_producto, CONCAT(nombre_cliente, ' ', apellido_cliente) cliente, comentario_producto, calificacion_producto, fecha_comentario
        FROM valoraciones
		INNER JOIN clientes USING(id_cliente)
        WHERE id_producto = ?";
        $params = array($this->producto);
        //Muestra todos los datos de la tabla productos
        return Database::getRows($sql, $params);
    }

    //Consulta para cargar un dato especifico de la tabla valoraciones
    public function readOne()
    {
        $sql = 'SELECT id_valoracion, id_producto, calificacion_producto, comentario_producto, fecha_comentario, estado_comentario
                FROM valoraciones
                WHERE id_valoracion = ?';
                //Guarda el id de la valoracion seleccionada
        $params = array($this->id);
        //Devuelve los datos de la valoracion seleccionada
        return Database::getRow($sql, $params);
    }
    //Elimina una valoracion en la base de datos
    public function deleteRow()
    {
        $sql = 'DELETE FROM valoraciones
                WHERE id_valoracion = ?';
                //Obtiene el id de la valoracion seleccionada
        $params = array($this->id);
        //Elimina la valoracion
        return Database::executeRow($sql, $params);
    }
    //Consulta para cambiar el estado de la valoracion
    public function changeStatus($status)
    {
        ($status) ? $status = 0 : $status = 1;
        $sql = 'UPDATE valoraciones
                SET estado_comentario = ?
                WHERE id_valoracion = ?';
                //Obtiene el id de la valoracion
        $params = array($status, $this->id);
        //Cambia el estado de la valoracion
        return Database::executeRow($sql, $params);
    }

    /**
     * Método para generar gráficas
     */
    public function promedioValoracionProducto()
    {
        $sql = 'SELECT p.nombre_producto, ROUND(AVG(v.calificacion_producto)) AS promedio_valoracion
            FROM valoraciones v
            INNER JOIN productos p ON v.id_producto = p.id_producto
            GROUP BY p.nombre_producto
            ORDER BY promedio_valoracion DESC';
        return Database::getRows($sql);
    }
}
