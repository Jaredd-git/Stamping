<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/producto_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad PRODUCTO.
*/
class Producto extends ProductoQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $nombre = null;
    protected $descripcion = null;
    protected $precio = null;
    protected $color = null;
    protected $estado = null;
    protected $tipo = null;
    protected $talla = null;

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

    public function setNombre($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->nombre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDescripcion($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->descripcion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPrecio($value)
    {
        if (Validator::validateMoney($value)) {
            $this->precio = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setColor($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->color = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipo($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->tipo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTalla($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->talla = $value;
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

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function getEstado()
    {
        return $this->estado;
    }
}
