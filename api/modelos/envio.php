<?php
class envio extends validator

{
    private $id=null;
    private $tipo=null;

    public function setID($value)
    {
        if($this->validateNaturalNumber($value)){
            $this->id=$value;
            return true;
        }else{
            return false;
        }

    } 

    public function setTipo($value)
    {
        if ($this->validateAlphanumeric($value, 1, 30)) {
            $this->tipo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function searchRows($value)
    {
        $sql = 'SELECT id_envio, tipo
                FROM envio
                WHERE tipo ILIKE ?
                ORDER BY tipo';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO envio(tipo)
                VALUES(?)';
        $params = array($this->tipo);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_envio, tipo
                FROM envio
                ORDER BY tipo';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_envio, tipo
                FROM envio
                WHERE id_envio = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow($current_image)
    {
        $sql = 'UPDATE envio
                SET tipo = ?
                WHERE id_envio = ?';
        $params = array($this->tipo, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM envio
                WHERE id_envio = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    } 
    
}
