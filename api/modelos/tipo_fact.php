<?php
class tipo_fact extends validator
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
        if ($this->validateAlphanumeric($value, 1, 30)) {
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
        $sql = 'SELECT id_tipofact,nombre
                FROM tipo_fact
                WHERE nombre ILIKE ?
                ORDER BY nombre';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO tipo_fact(nombre)
                VALUES(?)';
        $params = array($this->nombre);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_tipofact, nombre
                FROM tipo_fact
                ORDER BY nombre';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_tipofact, nombre
                FROM tipo_fact
                WHERE id_tipofact = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow($current_image)
    {
        $sql = 'UPDATE tipo_fact
                SET nombre = ?
                WHERE id_tipofact = ?';
        $params = array($this->nombre, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tipo_fact
                WHERE id_tipofact = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

}
