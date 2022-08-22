<?php
class zona extends validator
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
        $sql = 'SELECT id_zona,nombre_zona
                FROM zona
                WHERE nombre_zona ILIKE ?
                ORDER BY nombre_zona';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO zona(nombre_zona)
                VALUES(?)';
        $params = array($this->nombre);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_zona, nombre_zona
                FROM zona
                ORDER BY nombre_zona';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_zona, nombre_zona
                FROM zona
                WHERE id_zona = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow($current_image)
    {
        $sql = 'UPDATE zona
                SET nombre_zona = ?
                WHERE id_zona = ?';
        $params = array($this->nombre, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM zona
                WHERE id_zona = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

}