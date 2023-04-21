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
}
