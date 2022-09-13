<?php
include('../dashboard/correos.php');
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
    private $correo=null;
    private $token=null;

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
    
    public function setToken($value)
{
    if ($this->validateToken($value)) {
        $this->token = $value;
        return true;
    } else {
        return false;
    }
}


    public function setUsuario($value)
    {
        if ($this->validateAlphanumeric($value,1,50)) {
            $this->usuario = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setEmail($value)
    {
        if ($this->validateEmail($value)) {
            $this->correo = $value;
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
    public function getEmail()
    {
        return $this->correo;
    }


    public function getDireccion()
    {
        return $this->id;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }
    public function getClave()
    {
        return $this->clave;
    }

    public function getCargo()
    {
        return $this->cargo;
    }
    public function getToken()
    {
        return $this->token;
    }

    public function searchRows($value)
    {
        $sql = 'SELECT id_personal,nombre,dui,telefono,email,direccion,usuario,clave,nombre_cargo
                FROM personal INNER JOIN cargo USING (id_cargo)
                WHERE nombre ILIKE ? OR usuario ILIKE ?
                ORDER BY nombre';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO personal(nombre,dui,telefono,email,direccion,usuario,clave,id_cargo)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre,$this->dui, $this->telefono,$this->correo,$this->direccion,$this->usuario,$this->clave,$this->cargo);
        return Database::executeRow($sql, $params);
    }
    public function registro()
    {
        $sql = "WITH auto_cargo as (
          INSERT INTO cargo (nombre_cargo) VALUES ('propietario') 
          RETURNING id_cargo)
        INSERT INTO personal (nombre,email,telefono,usuario,clave,id_cargo)
        VALUES (?,?,?,?,?,(SELECT id_cargo FROM auto_cargo))";
        $params = array($this->nombre,$this->correo, $this->telefono,$this->usuario,$this->clave);
        return Database::executeRow($sql, $params);
    }
    public function readAll()
    {
        $sql = 'SELECT id_personal, nombre,dui,email,telefono,direccion,usuario,clave,nombre_cargo
                FROM personal inner join cargo using(id_cargo)
                ORDER BY nombre';
         $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_personal, nombre,dui,email,telefono,direccion,usuario,clave,nombre_cargo
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
            $this->id = $data['id_personal'];
            $this->usuario = $usuario;
            return true;
        } else {
            return false;
        }
    }
    public function checkEmail($correo)
    {
        $sql = 'SELECT id_personal FROM personal WHERE email = ?';
        $params = array($correo);
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['id_personal'];
            $this->correo = $correo;
            return true;
        } else {
            return false;
        }
    }
    public function saveToken()
    {
        global $codigo;
        $sql = 'UPDATE personal SET token = ? WHERE id_personal = ?';
        $params = array($codigo,$this->id);
        return Database::executeRow($sql, $params);
    }
    public function checkToken($token)
    {
        global $codigo;
        $sql = 'SELECT id_personal FROM personal WHERE token = ?';
        $params = array($token);
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['id_personal'];
            $this->token=$codigo;
            return true;
        } else {
            return false;
        }
    }
    public function forgetPassword()
    {
        $sql = 'UPDATE personal SET clave = ? WHERE id_personal = ?';
        $params = array($this->clave,$this->id);
        return Database::executeRow($sql, $params);
    }
    public function checkPassword($password)
    {
        $sql = 'SELECT clave FROM personal WHERE id_personal = ?';
        $params = array($this->id);
        $data = Database::getRow($sql, $params);
        // Se verifica si la contraseña coincide con el hash almacenado en la base de datos.
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
    public function updateRow()
    {
        $sql = 'UPDATE personal
                SET nombres = ?,telefono = ?,email=?
                WHERE id_personal = ?';
        $params = array($this->nombre,$this->telefono,$this->correo, $this->id);
        return Database::executeRow($sql, $params);
    }
    public function editProfile()
    {
        $sql = 'UPDATE personal
                SET nombre =? ,dui=?,telefono=?,email=?,direccion=?
                WHERE id_personal = ?';
        $params = array($this->nombre, $this->dui, $this->telefono,$this->correo, $_SESSION['id_personal']);
        return Database::executeRow($sql, $params);
    }
    //REPORTE
    public function readPeronalCargo()
    {
        $sql = 'SELECT nombre,nombre_cargo
        FROM personal INNER JOIN cargo USING (id_cargo)
        WHERE id_cargo = ?
        order by id_cargo';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }
    public function personalcargo()
    {
    $sql = 'SELECT c.id_cargo,p.nombre,p.telefono,p.direccion,c.nombre_cargo
    FROM personal p INNER JOIN cargo c USING (id_cargo)
    WHERE id_cargo = ?
    order by c.id_cargo';
      $params = array($this->cargo);
      return Database::getRows($sql, $params);
}
//graficos 
//Grafica para mostrar la cantidad de pedidos de cada zona
public function cantidadPedidosZona()
{
    $sql = 'SELECT COUNT(*) AS pedidos, nombre_zona
    FROM pedidos INNER JOIN zona USING(id_zona) 
    GROUP BY nombre_zona';
    $params = null;
    return Database::getRows($sql, $params);
}

 public function cantidadPersonalCargo()
 {
     $sql = 'SELECT count(*) as personal, nombre_cargo
     from personal inner join cargo using (id_cargo)
     group by nombre_cargo order by personal ';
     $params = null;
     return Database::getRows($sql, $params);
 }
 public function cantidadPedidosPersonal()
 {
     $sql = 'SELECT count(*) as pedidos, nombre
     from pedidos inner join personal using (id_personal)
     group by nombre limit 5';
     $params = null;
     return Database::getRows($sql, $params);
 }

}
