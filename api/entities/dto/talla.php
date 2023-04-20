<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/talla_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad CATEGORIA.
*/
class Talla extends TallaQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $talla = null;

    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getId()
    {
        return $this->id;
    }

    public function getTalla()
    {
        return $this->talla;
    }
}
