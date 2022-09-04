<?php
class clientes extends validator
{
    private $idcliente=null;
    private $nombre=null;
    private $autoridbnm = null;
    private $nacimiento = null;
    private $nombrecont = null;
    private $horario = null;
    private $direccion = null;
    private $dui = null;
    private $nit = null;
    private $nrc = null;
    private $montmaxvent = null;
    private $descauto = null;
    private $nojunta = null;
    private $especialidad = null;
    private $institucion = null;




//---------------- S E T S ----------------------------------------------------------------------------------------------//-----------------------

    public function setIdCl($value)
    {
        if($this->validateNaturalNumber($value)){
            $this->idcliente=$value;
            return true;
        }else{
            return false;
        }

    }  

    public function setNombre($value)
    {
        if ($this->validateAlphanumeric($value, 1, 50)) {
            $this->nombre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setAutodnm($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->autoridnm = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setINac($value)
    {
        if ($this->validateDate($value)) {
            $this->nacimiento = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setICont($value)
    {
        if ($this->validateAlphabetic($value,1,50)) {
            $this->nombrecont= $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIHorario($value)
    {
        if ($this->validateString($value,1,50)) {
            $this->horario = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setDireccion($value)
    {
        if ($this->validateAlphanumeric($value,1,50)) {
            $this->direccion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDui($value)
    {
        if ($this->validateDUI($value)) {
            $this->dui = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNit($value)
    {
        if ($this->validateNIT($value)) {
            $this->nit = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setNrc($value)
    {
        if ($this->validateAlphanumeric($value,1,40)) {
            $this->nrc = $value;
            return true;
        } else {
            return false;
        }
    }


    
    public function setMontMaxVent($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->monmaxvent = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setDescuento($value)
    {
        if ($this->validateNaturalnumber($value)) {
            $this->descauto = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setNumerojunta($value)
    {
        if ($this->validateNaturalnumber($value)) {
            $this->nojunta = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEspeci($value)
    {
        if ($this->validateNaturalnumber($value)) {
            $this->especialidad = $value;
            return true;
        } else {
            return false;
        }
    }



    public function setInsti($value)
    {
        if ($this->validateNaturalnumber($value)) {
            $this->institucion = $value;
            return true;
        } else {
            return false;
        }
    }



    





//---------------------Returns ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

    public function getIdCl()
    {
        return $this->idcliente;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getAutodnm()
    {
        return $this->cantidad;
    }

    public function getNac()
    {
        return $this->nacimiento;
    }

    public function getIcount()
    {
        return $this->nombrecont;
    }

    public function getHorario()
    {
        return $this->horario;
    }

    public function getDireccion()
    {
        return $this->direccion0;
    }

    public function getDUl()
    {
        return $this->dui;
    }


    public function getNrc()
    {
        return $this->nrc;
    }


    public function getMontomaximo()
    {
        return $this->montmaxvent;
    }


    public function getDescuento()
    {
        return $this->descauto;
    }


    public function getNumerojunta()
    {
        return $this->nojunta;
    }

    public function getIdEspeci()
    {
        return $this->especialidad;
    }

    public function getIdInsti()
    {
        return $this->institucion;
    }

    public function getNit()
    {
        return $this->nit;
    }
   

//----- Consultas-----------------------------------//------------------------------------------------------------


    public function searchRows($value)
    {
        $sql = 'SELECT id_cliente , nombre , nrc                                           
                FROM cliente
                WHERE nombre  ILIKE ?
                ORDER BY nombre';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO cliente (id_cliente, nombre , autoridnm , nacimiento , horario , direccion , dui, nit , nrc,
		mont_maxvent,desc_auto , nojunta,id_especi,id_insti)
	values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
        $params = array($this->idcliente,$this->nombre,$this->autoridnm,$this->nacimiento,$this->horario,$this->direccion,$this->dui,
        $this->nit,$this->nrc,$this->montmaxvent,$this->nojunta,$this->idespeci,$this->idinsti);
        return Database::executeRow($sql, $params);
    }

    public function readAllInsti()
    {
        $sql = 'SELECT id_cliente, nombre , direccion ,horario, nrc,tipo_insti
        FROM cliente inner join institucion using(id_insti)
        ORDER BY id_cliente';
        $params = null;
        return Database::getRows($sql, $params);
    }
    public function readAllMedi()
    {
        $sql = 'SELECT id_cliente,nombre,nombre_especi, direccion ,horario, nrc
        FROM cliente inner join especialidad using(id_especi)
        ORDER BY id_cliente';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_cliente , nombre , dui 
                FROM cliente
                WHERE id_cliente = ?';
        $params = array($this->idcliente);
        return Database::getRow($sql, $params);
    }

    public function updateRow($current_image)
    {
        $sql = 'UPDATE cliente
                SET nombre = ?
                WHERE id_cliente = ?';
        $params = array($this->nombre, $this->idcliente);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM cliente
                WHERE id_cliente = ?';
        $params = array($this->idcliente);
        return Database::executeRow($sql, $params);
    }

    public function clienteInstitucion()
    {
        $sql = 'SELECT nombre,nombre_cont,horario from cliente inner join institucion using (id_insti)
        where id_insti =?';
        $params = array($this->institucion);
        return Database::getRows($sql, $params);
    }
    public function clienteespecialidad()
    {
        $sql = 'SELECT nombre,nombre_especi from cliente inner join especialidad using (id_especi)
        where id_especi =?';
        $params = array($this->especialidad);
        return Database::getRow($sql, $params);
    }
      //Metodo para generar graficas

    //grafica clientes que hacen mas pedidos
    public function ClientesPedidos()
    {
        $sql = 'SELECT COUNT(*) AS "pedidos", nombre
                FROM pedidos INNER JOIN cliente USING(id_cliente)
                GROUP BY nombre ORDER BY pedidos DESC
                LIMIT 5';
        $params = null;
        return Database::getRows($sql, $params);
    }


    public function personalPedido()
    {
        $sql = 'SELECT Count(*) as pedidos ,nombre
    From pedidos inner join cliente using (id_cliente)
    group by nombre';
        $params = null;
        return Database::getRows($sql, $params);
    }
}
?>