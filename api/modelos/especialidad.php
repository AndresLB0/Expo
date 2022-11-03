<?php
class especialidad extends validator

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
        $sql = 'SELECT id_especi, nombre_especi
                FROM especialidad
                WHERE nombre_especi ILIKE ?
                ORDER BY nombre_especi';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO especialidad(nombre_especi)
                VALUES(?)';
        $params = array($this->nombre);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_especi, nombre_especi
                FROM especialidad
                ORDER BY nombre_especi';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_especi, nombre_especi
                FROM especialidad
                WHERE id_especi = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE especialidad
                SET nombre_especi = ?
                WHERE id_especi = ?';
        $params = array($this->nombre_especi, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM especialidad
                WHERE id_especi = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    } 
    
}
