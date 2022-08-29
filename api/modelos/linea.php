<?php
class linea extends validator
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
        $sql = 'SELECT id_linea,nombre_linea
                FROM linea
                WHERE nombre_linea ILIKE ?
                ORDER BY nombre_linea';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO linea(nombre_linea)
                VALUES(?)';
        $params = array($this->nombre);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_linea, nombre_linea
                FROM linea
                ORDER BY nombre_linea';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_linea, nombre_linea
                FROM linea
                WHERE id_linea = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow($current_image)
    {
        $sql = 'UPDATE linea
                SET nombre_linea = ?
                WHERE id_linea = ?';
        $params = array($this->nombre, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM linea
                WHERE id_linea = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
