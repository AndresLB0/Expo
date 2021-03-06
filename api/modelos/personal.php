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
        $sql = 'INSERT INTO personal(nombre,dui,telefono,direccion,usuario,clave,id_cargo)
                VALUES(?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->contacto, $this->telefono);
        return Database::executeRow($sql, $params);
    }
    public function readAll()
    {
        $sql = 'SELECT id_personal, nombre,dui,telefono,direccion,usuario,clave,nombre_cargo
                FROM personal INNER JOIN cargo USING (id_cargo)
                ORDER BY nombre';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_personal, nombre,dui,telefono,direccion,usuario,clave,nombre_cargo
        FROM personal INNER JOIN cargo USING (id_cargo)
                WHERE id_personal = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }
    public function deleteRow()
    {
        $sql = 'DELETE FROM personal
                WHERE id_personal = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function checkUser($usuario)
    {
        $sql = 'SELECT id_personal FROM personal WHERE usuario = ?';
        $params = array($usuario);
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['id_usuario'];
            $this->usuario = $usuario;
            return true;
        } else {
            return false;
        }
    }
    public function checkPassword($password)
    {
        $sql = 'SELECT clave FROM personal WHERE id_personal = ?';
        $params = array($this->id);
        $data = Database::getRow($sql, $params);
        // Se verifica si la contrase??a coincide con el hash almacenado en la base de datos.
        if (password_verify($password, $data['clave'])) {
            return true;
        } else {
            return false;
        }
    }
    public function changePassword()
    {
        $sql = 'UPDATE personal SET clave = ? WHERE id_personal = ?';
        $params = array($this->clave, $_SESSION['id_personal']);
        return Database::executeRow($sql, $params);
    }

    public function readProfile()
    {
        $sql = 'SELECT id_personal,nombre,dui,telefono,direccion,usuario,clave,nombre_cargo
                FROM personal
                WHERE id_personal = ?';
        $params = array($_SESSION['id_personal']);
        return Database::getRow($sql, $params);
    }

    public function editProfile()
    {
        $sql = 'UPDATE personal
                SET nombre =? ,dui=?,telefono=?,direccion=?,usuario=?,clave=?,nombre_cargo=?
                WHERE id_personal = ?';
        $params = array($this->nombre, $this->dui, $this->telefono, $_SESSION['id_personal']);
        return Database::executeRow($sql, $params);
    }
}