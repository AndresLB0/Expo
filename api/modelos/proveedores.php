<?php
class proveedor extends validator
{
    private $id=null;
    private $nombre=null;
    private $contacto=null;
    private $telefono=null;

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
    public function setContacto($value)
    {
        if ($this->validateAlphanumeric($value, 1, 50)) {
            $this->contacto = $value;
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
    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
    public function getContacto()
    {
        return $this->contacto;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }
    public function searchRows($value)
    {
        $sql = 'SELECT id_provee,nombre,nombre_contacto,telefono
                FROM proveedor
                WHERE nombre ILIKE ? OR nombre contacto ILIKE ?
                ORDER BY nombre';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }
    public function createRow()
    {
        $sql = 'INSERT INTO proveedor(nombre,nombre_contacto,telefono)
                VALUES(?, ?, ?)';
        $params = array($this->nombre, $this->contacto, $this->telefono);
        return Database::executeRow($sql, $params);
    }
    public function readAll()
    {
        $sql = 'SELECT id_provee, nombre,nombre_contacto,telefono
                FROM proveedor
                ORDER BY nombre';
        $params = null;
        return Database::getRows($sql, $params);
    }
    public function readOne()
    {
        $sql = 'SELECT id_provee, nombre,nombre_contacto,telefono
                FROM proveedor
                WHERE id_provee = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow($current_image)
    {
        $sql = 'UPDATE proveedor
                SET nombre = ?, nombre_contacto = ?, telefono= ?
                WHERE id_provee = ?';
        $params = array($this->nombre, $this->contacto, $this->telefono, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM proveedor
                WHERE id_provee = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

}
