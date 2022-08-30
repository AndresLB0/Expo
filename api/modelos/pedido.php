
<?php
class pedidos extends validator
{
    private $idpedidos=null;
    private $fecha=null;
    private $hora = null;
    private $tiempocredi = null;
    private $totalpagar = null;
    private $fechapago = null;
    private $idpersonal = null;
    private $idtipofact = null;
    private $idenvio = null;
    private $idcliente = null;
    private $idzona = null;
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

    public function setFecha($value)
    {
        if ($this-> validateDate($value)) {
            $this->fecha = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setHora($value)
    {
        if ($this->validateTime($value)) {
            $this->hora = $value;
            return true;
        } else {
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


    public function setIdPersonal($value)
    {
        if($this->validateNaturalNumber($value)){
            $this->idpersonal=$value;
            return true;
        }else{
            return false;
        }
    }


    public function setIdTipoFact($value)
    {
        if($this->validateNaturalNumber($value)){
            $this->idtipofact =$value;
            return true;
        }else{
            return false;
        }
    }


    public function setIdEnvio($value)
    {
        if($this->validateNaturalNumber($value)){
            $this->idenvio =$value;
            return true;
        }else{
            return false;
        }
    }



    public function setIdCliente($value)
    {
        if($this->validateNaturalNumber($value)){
            $this->idcliente =$value;
            return true;
        }else{
            return false;
        }
    }


    public function setIdZona($value)
    {
        if($this->validateNaturalNumber($value)){
            $this->idzona =$value;
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

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getHora()
    {
        return $this->hora;
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

    public function getIdPersonal()
    {
        return $this->idpersonal;
    }

    public function getIdTipoFact()
    {
        return $this->idtipofact;
    }

    public function getIdEnvio()
    {
        return $this->idenvio;
    }

    public function getIdCliente()
    {
        return $this->idcliente;
    }

    public function getIdZona()
    {
        return $this->idzona;
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
      $params = array($this->idcliente);
      return Database::getRows($sql, $params);
    }
    public function pedidoenvio()
    {
    $sql = 'SELECT nombre,nombre_zona,total_pagar from pedidos inner join cliente using(id_cliente) inner join zona using(id_zona)
    where id_envio=?';
      $params =array($this->idenvio);
      return Database::getRows($sql, $params);
    }



}