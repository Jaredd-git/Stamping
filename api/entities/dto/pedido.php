<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/detallepedido_queries.php');
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
    protected $id_detalle = null;
    protected $producto = null;
    protected $talla = null;
    protected $cantidad = null;
    protected $precio = null;

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
     *   Detalles pedidos
    */

    public function setIdDetalle($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_detalle = $value;
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

    public function setTalla($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->talla = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCantidad($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cantidad = $value;
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

    /*
    *   Métodos para obtener valores de los atributos (Detalle Pedidos).
    */

    public function getIdDetalle()
    {
        return $this->id_detalle;
    }

    public function getProducto()
    {
        return $this->producto;
    }

    public function getTalla()
    {
        return $this->talla;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function getPrecio()
    {
        return $this->precio;
    }
}
