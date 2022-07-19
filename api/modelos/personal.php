<?php
class personal extends validator
{
    private $id=null;
    private $nombre=null;
    private $dui=null;
    private $telefono=null;
    private $direccion=null;
    private $usuario=null;
    private $clave=null;
    private $cargo=null;

    public function setID($value)
    {
        if($this->validateNaturalNumber($value)){
            $this->id=$value;
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

    public function setDUI($value)
    {
        if ($this->validateDUI($value)) {
            $this->dui = $value;
            return true;
        } else {
            return false;
        
    } 
}

public function setTelefono($value)
{
    if ($this->validatePhone($value)) {
        $this->telefono = $value;
        return true;
    } else {
        return false;
    }
}

public function setDireccion($value)
    {
        if ($this->validateString($value, 1, 200)) {
            $this->direccion = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setUsuario($value)
    {
        if ($this->validateAlphanumeric($value)) {
            $this->usuario = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setClave($value)
    {
        if ($this->validatePassword($value)) {
            $this->clave = password_hash ($value, PASSWORD_DEFAULT);
            return true;
        } else {
            return false;
        }
    }

    public function setCargo($value)
    {
        if($this->validateNaturalNumber($value)){
            $this->cargo=$value;
            return true;
        }else{
            return false;
        }

    }  

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
    public function getDUI()
    {
        return $this->contacto;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getDireccion()
    {
        return $this->id;
    }

    public function getUsuario()
    {
        return $this->nombre;
    }
    public function getClave()
    {
        return $this->contacto;
    }

    public function getCargo()
    {
        return $this->telefono;
    }

    public function searchRows($value)
    {
        $sql = 'SELECT id_personal,nombre,dui,telefono,direccion,usuario,clave,nombre_cargo
                FROM personal INNER JOIN cargo USING (id_cargo)
                WHERE nombre ILIKE ? OR usuario ILIKE ?
                ORDER BY nombre';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO personal(nombre,dui,telefono,direccion,usuario,clave,nombre_cargo)
                VALUES(?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->contacto, $this->telefono);
        return Database::executeRow($sql, $params);
    }




}