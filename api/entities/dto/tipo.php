<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/tipo_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CATEGORIA.
*/
class Tipo extends TipoQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $nombreTipo = null;
    protected $descripcion = null;
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

    public function setNombreTipo($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->nombres = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDescripcion($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->descripcion = $value;
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

    public function getNombreTipo()
    {
        return $this->nombreTipo;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }


}
