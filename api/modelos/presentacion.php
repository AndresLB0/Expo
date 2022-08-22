<?php
class presentacion extends validator

{
    private $id=null;
    private $presen=null;

    public function setID($value)
    {
        if($this->validateNaturalNumber($value)){
            $this->id=$value;
            return true;
        }else{
            return false;
        }

    } 

    public function setPresentacio($value)
    {
        if ($this->validateAlphanumeric($value, 1, 100)) {
            $this->presen = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPresentacio()
    {
        return $this->presen;
    }

    public function searchRows($value)
    {
        $sql = 'SELECT id_presentacion, presentacio
                FROM presentacion
                WHERE presentacio ILIKE ?
                ORDER BY presentacio';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO presentacion(presentacio)
                VALUES(?)';
        $params = array($this->presen);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_presentacion, presentacio
                FROM presentacion
                ORDER BY presentacio';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_presentacion, presentacio
                FROM presentacion
                WHERE id_presentacion = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow($current_image)
    {
        $sql = 'UPDATE presentacion
                SET presentacio = ?
                WHERE id_presentacion = ?';
        $params = array($this->presen, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM presentacion
                WHERE id_presentacion = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    } 
    
}
