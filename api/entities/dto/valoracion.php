<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/valoracion_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CLIENTE.
*/
class Valoraciones extends ValoracionQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $producto = null;
    protected $calificacion = null;
    protected $comentario = null;
    protected $fecha = null;
    protected $estado = null; // Valor por defecto en la base de datos: true

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setProducto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCalificacion($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->calificacion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFecha($value)
    {
        if (Validator::validateDate($value)) {
            $this->fecha = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setComentario($value)
    {
        if (Validator::validateString($value, 1, 200)) {
            $this->comentario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstado($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estado = $value;
            return true;
        } else {
            return false;
        }
    }

    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getId()
    {
        return $this->id;
    }

    public function getProducto()
    {
        return $this->producto;
    }

    public function getCalificacion()
    {
        return $this->calificacion;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getComentario()
    {
        return $this->comentario;
    }

    public function getEstado()
    {
        return $this->estado;
    }
}
