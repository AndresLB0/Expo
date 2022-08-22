<?php
class institucion extends validator

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
        if ($this->validateAlphanumeric($value, 1, 50)) {
            $this->tipo_insti = $value;
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
        $sql = 'SELECT id_insti, tipo_insti
                FROM institucion
                WHERE tipo_insti ILIKE ?
                ORDER BY tipo_insti';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO institucion(tipo_insti)
                VALUES(?)';
        $params = array($this->tipo_insti);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_insti, tipo_insti
                FROM institucion
                ORDER BY tipo_insti';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_insti, tipo_insti
                FROM institucion
                WHERE id_insti = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow($current_image)
    {
        $sql = 'UPDATE institucion
                SET tipo_insti = ?
                WHERE id_insti = ?';
        $params = array($this->tipo_insti, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM institucion
                WHERE id_isti = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    } 
    
}
