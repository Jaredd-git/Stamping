<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/pedido_queries.php');
/*
*	Clase para manejar la transferencia de datos de las entidades PEDIDO y DETALLE_PEDIDO.
*/
class Pedido extends PedidoQueries
{
    // Declaración de atributos (propiedades).
    protected $id_pedido = null;
    protected $id_cliente = null;
    protected $id_estado = null;
    protected $fecha_pedido = null;
    protected $direccion_pedido = null;

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setIdPedido($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstado($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_estado = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFechaPedido($value)
    {
        if (Validator::validateDate($value)) {
            $this->fecha_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDireccion($value)
    {
        if (Validator::validateString($value)) {
            $this->direccion_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    /*
    *   Métodos para obtener valores de los atributos (Pedidos).
    */
    public function getIdPedido()
    {
        return $this->id_pedido;
    }

    public function getCliente()
    {
        return $this->id_cliente;
    }

    public function getEstado()
    {
        return $this->id_estado;
    }

    public function getFechaPedido()
    {
        return $this->fecha_pedido;
    }

    public function getDireccion()
    {
        return $this->direccion_pedido;
    }
}
