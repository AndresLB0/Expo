<?php
class cargo extends validator
{
    private $id=null;
    private $nombre=null;
    
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

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function searchRows($value)
    {
        $sql = 'SELECT id_cargo,nombre_cargo
                FROM cargo
                WHERE nombre_cargo ILIKE ?
                ORDER BY nombre_cargo';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO cargo(nombre_cargo)
                VALUES(?)';
        $params = array($this->nombre);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_cargo, nombre_cargo
                FROM cargo
                ORDER BY nombre_cargo';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_cargo, nombre_cargo
                FROM cargo
                WHERE id_cargo = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow($current_image)
    {
        $sql = 'UPDATE cargo
                SET nombre_cargo = ?
                WHERE id_cargo = ?';
        $params = array($this->nombre, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM cargo
                WHERE id_cargo = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

}
?>
