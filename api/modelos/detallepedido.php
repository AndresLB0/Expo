<?php
class detallepedido extends validator
{
    private $iddetallepid=null;
    private $precio=null;
    private $cantidad = null;
    private $idproducto = null;
    private $idpedidos = null;


//---------------- S E T S ----------------------------------------------------------------------------------------------//-----------------------

    public function setIdDP($value)
    {
        if($this->validateNaturalNumber($value)){
            $this->iddetallepid=$value;
            return true;
        }else{
            return false;
        }

    }  

    public function setPrecio($value)
    {
        if ($this->validateNumeric($value, 1, 50)) {
            $this->precio = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCantidad($value)
    {
        if ($this->validateNumeric($value, 1, 50)) {
            $this->cantidad = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdpedidos($value)
    {
        if ($this->validateNumeric($value, 1, 50)) {
            $this->idpedidos = $value;
            return true;
        } else {
            return false;
        }
    }



    public function setIdProd($value)
    {
        if ($this->validateNumeric($value, 1, 50)) {
            $this->idproducto = $value;
            return true;
        } else {
            return false;
        }
    }



//---------------------Returns ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

    public function getIdpedi()
    {
        return $this->iddetallepid;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function getIdprod()
    {
        return $this->idproducto;
    }

    public function getID()
    {
        return $this->idpedidos;
    }


//----- Consultas-----------------------------------//------------------------------------------------------------


    public function searchRows($value)
    {
        $sql = 'SELECT id_detapedi , precio , id_pedidos
                FROM detalle_pedido
               
                ORDER BY precio';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO detalle_pedido (id_detapedi , precio , id_pedidos , cantidad) VALUES (?,?,?,?,?)';
        $params = array($this->iddetallepid,$this->precio,$this->cantidad,$this->$this->idproducto,$this->idpedido);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_detallepedi , cantidad , precio
                FROM detalle_pedido
                ORDER BY cantidad';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_detallepedi , cantidad , precio
        FROM detalle_pedido
                WHERE id_detallepedi = ?';
        $params = array($this->iddetallepedi);
        return Database::getRow($sql, $params);
    }

    public function updateRow($current_image)
    {
        $sql = 'UPDATE detalle_pedido
                SET precio = ?
                WHERE id_detallepedi = ?';
        $params = array($this->precio, $this->iddetallepedi);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM detalle_pedido
                WHERE id_detallepedi = ?';
        $params = array($this->iddetallepedi);
        return Database::executeRow($sql, $params);
    }

}
?>