
<?php
class pedidos extends validator
{
    private $idpedidos=null;
    private $iddetalle=null;
    private $precio=null;
    private $cantidad=null;
    private $producto=null;
    private $tiempocredi = null;
    private $totalpagar = null;
    private $fechapago = null;
    private $personal = null;
    private $tipofact = null;
    private $envio = null;
    private $cliente = null;
    private $zona = null;
    private $estadopedido = null;


//---------------- S E T S ----------------------------------------------------------------------------------------------//-----------------------

    public function setId($value)
    {
        if($this->validateNaturalNumber($value)){
            $this->idpedidos=$value;
            return true;
        }else{
            return false;
        }

    }  
    public function setPrecio($value)
    {
        if ($this->validateMoney($value)) {
            $this->precio = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setIdDetalle($value)
    {
        if($this->validateNaturalNumber($value)){
            $this->iddetalle=$value;
            return true;
        }else{
            return false;
        }

    } public function setCantidad($value)
    {
        if($this->validateNaturalNumber($value)){
            $this->cantidad=$value;
            return true;
        }else{
            return false;
        }
    }
    public function setProducto($value)
    {
        if($this->validateNaturalNumber($value)){
            $this->producto=$value;
            return true;
        }else{
            return false;
        }
    }

    public function setTiempocredi($value)
    {
        if ($this-> validateDate($value)) {
            $this->tiempocredi = $value;
            return true;
        } else {
            return false;
        }
    }



    public function setTotalpagar($value)
    {
        if ($this->validateMoney($value)) {
            $this->totalpagar = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFechapago($value)
    {
        if ($this-> validateDate($value)) {
            $this->fechapago = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setPersonal($value)
    {
        if($this->validateNaturalNumber($value)){
            $this->personal=$value;
            return true;
        }else{
            return false;
        }
    }


    public function setTipoFact($value)
    {
        if($this->validateNaturalNumber($value)){
            $this->tipofact =$value;
            return true;
        }else{
            return false;
        }
    }


    public function setEnvio($value)
    {
        if($this->validateNaturalNumber($value)){
            $this->envio =$value;
            return true;
        }else{
            return false;
        }
    }



    public function setCliente($value)
    {
        if($this->validateNaturalNumber($value)){
            $this->cliente =$value;
            return true;
        }else{
            return false;
        }
    }


    public function setZona($value)
    {
        if($this->validateNaturalNumber($value)){
            $this->zona =$value;
            return true;
        }else{
            return false;
        }
    }



    public function setEstadoPedido($value)
    {
        if($this->validateBoolean($value)){
            $this->estadopedido =$value;
            return true;
        }else{
            return false;
        }
    }






//---------------------Returns ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

    public function getId()
    {
        return $this->idpedidos;
    }
    public function getIdDetalle()
    {
        return $this->iddetalle;
    }
    public function getPrecio()
    {
        return $this->precio;
    }
    public function getCantidad()
    {
        return $this->cantidad;
    }
    public function getProducto()
    {
        return $this->producto;
    }
    public function getTiempocredi()
    {
        return $this->tiempocredi;
    }

    public function getTotalpagar()
    {
        return $this->totalpagar;
    }

    public function getFechapago()
    {
        return $this->fechapago;
    }

    public function getPersonal()
    {
        return $this->personal;
    }

    public function getTipoFact()
    {
        return $this->tipofact;
    }

    public function getEnvio()
    {
        return $this->envio;
    }

    public function getCliente()
    {
        return $this->cliente;
    }

    public function getZona()
    {
        return $this->zona;
    }

    public function EstadoPedido()
    {
        return $this->estadopedido;
    }
//consultas
    public function pedidocliente()
    {
    $sql = 'SELECT distinct nombre_producto,cantidad,precio_iva,precio,fecha,nombre_zona
    from detalle_pedido inner join pedidos using(id_pedidos)inner join producto using(id_producto) inner join cliente using (id_cliente) 
    inner join zona using(id_zona)
    where id_cliente=?
    ';
      $params = array($this->cliente);
      return Database::getRows($sql, $params);
    }
    public function pedidoenvio()
    {
    $sql = 'SELECT nombre,nombre_zona,total_pagar from pedidos inner join cliente using(id_cliente) inner join zona using(id_zona)
    where id_envio=?';
      $params =array($this->envio);
      return Database::getRows($sql, $params);
    }



}