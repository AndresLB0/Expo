<?php
/*
*	Clase para manejar la tabla productos de la base de datos.
*   Es clase hija de Validator.
*/
class Productos extends Validator
{
    // Declaración de atributos (propiedades).
    private $id = null;
    private $nombre = null;
    private $descripcion = null;
    private $precio_fact = null;
    private $precio_iva = null;
    private $proveedor = null;
    private $presentacion = null;
    private $descuento = null;
    private $linea = null;
    private $registro = null;
    private $tamanio = null;
    private $existencias=null;
    private $precio_farmacia=null;
    private $precioiva_farmacia=null;

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setId($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
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

    public function setDescripcion($value)
    {
        if ($this->validateString($value, 1, 250)) {
            $this->descripcion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPrecioFactu($value)
    {
        if ($this->validateMoney($value)) {
            $this->precio_fact = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setPrecioIVA($value)
    {
        if ($this->validateMoney($value)) {
            $this->precio_IVA = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setProvee($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->proveedor = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setExistencias($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->existencias = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setDesc($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->descuento = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setTamanio($value)
    {
        if ($this->validateAlphanumeric($value, 1, 50)) {
            $this->tamanio = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setRegistro($value)
    {
        if ($this->validateAlphanumeric($value, 1, 50)) {
            $this->registro = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setLinea($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->linea = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setPresentacion($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->presentacion = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setPrecioFarmacia($value)
    {
        if ($this->validateMoney($value)) {
            $this->precio_farmacia = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setPrecioIvaFarmacia($value)
    {
        if ($this->validateMoney($value)) {
            $this->precioiva_farmacia = $value;
            return true;
        } else {
            return false;
        }
    }

    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function getPrecio_factu()
    {
        return $this->precio_fact;
    }
    public function getPrecio_IVA()
    {
        return $this->precio_IVA;
    }
    public function getProvee()
    {
        return $this->proveedor;
    }
    public function getExistencias()
    {
        return $this->existencias;
    }
    public function getDescuento()
    {
        return $this->descuento;
    }
    public function getRegistro()
    {
        return $this->registro;
    }
    public function getTamanio()
    {
        return $this->tamanio;
    }
    public function getLinea()
    {
        return $this->linea;
    }
    public function getPresentacion()
    {
        return $this->presentacion;
    }
    public function getPrecioFarmacia()
    {
        return $this->precio_farmacia;
    }
    public function getPrecioIvaFarmacia()
    {
        return $this->precioiva_farmacia;
    }

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_producto, nombre_producto, descripcion, precio_fact,precio_iva,presentacio,nombre,nombre_linea,existencias, estado_producto
        FROM producto INNER JOIN proveedor USING(id_provee) INNER join presentacion using(id_presentacion) inner join linea using(id_linea)
        WHERE nombre_producto ILIKE ? OR descripcion ILIKE ?
        ORDER BY nombre_producto
';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO producto(nombre_producto, descripcion,reg_san,tamanio, precio_fact,precio_iva,descuento,existencias, id_provee,id_linea,id_presentacion,precio_farmacia,precicioiva_farmacia)
                VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)';
        $params = array($this->nombre,$this->descripcion,$this->registro,$this->tamanio,$this->precio_fact,$this->precio_iva,$this->descuento,$this->existencias,$this->proveedor,$this->linea,$this->presentacion,$this->precio_farmacia,$this->precioiva_farmacia);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_producto, nombre_producto, descripcion, precio_iva, nombre,existencias,presentacio, estado_producto
                FROM producto INNER JOIN proveedor USING(id_provee) inner join presentacion using(id_presentacion)
                ORDER BY nombre_producto';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_producto, nombre_producto, descripcion_producto, precio_producto, imagen_producto, id_provee, estado_producto,existencias,id_presentacion
                FROM producto
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        // Se verifica si existe una nueva imagen para borrar la actual, de lo contrario se mantiene la actual.

        $sql = 'UPDATE producto
                SET imagen_producto = ?, nombre_producto = ?, descripcion_producto = ?, precio_producto = ?, estado_producto = ?, id_provee = ?,id_presentacion=?,existencias=?
                WHERE id_producto = ?';
        $params = array($this->imagen, $this->nombre, $this->descripcion, $this->precio, $this->estado, $this->proveedor, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM producto
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function readProductosProvee()
    {
        $sql = 'SELECT id_producto, imagen_producto, nombre_producto, descripcion_producto, precio_producto
                FROM producto INNER JOIN proveedor USING(id_provee)
                WHERE id_provee = ? AND estado_producto = true
                ORDER BY nombre_producto';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }
    public function readproductoTipo()
    {
        $sql = 'SELECT id_producto, imagen, nombre, descripcion, precio
                FROM producto INNER JOIN presentacion USING(id_presentacion)
                WHERE id_presentacion = ? AND estado = true
                ORDER BY nombre';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }


    /*
    *   Métodos para generar reportes.
    */
    public function productosproveedor()
    {
    $sql = 'SELECT distinct nombre_producto,precio_fact,nombre,existencias,presentacio,nombre_linea
    FROM producto inner join proveedor using(id_provee) inner join presentacion using(id_presentacion) inner join linea using(id_linea)
    WHERE id_provee =?';
      $params = array($this->proveedor);
      return Database::getRows($sql, $params);
}
public function productopresentacion()
{
$sql = 'SELECT nombre_producto,precio_iva,presentacio,existencias,vence
FROM lote inner join producto inner join presentacion using(id_presentacion) using(id_producto)
WHERE id_presentacion =?
order by id_presentacion';
  $params = array($this->presentacion);
  return Database::getRows($sql, $params);
}
public function productolinea()
{
$sql = 'SELECT nombre_producto,precio_fact,nombre_linea,existencias
FROM producto inner join proveedor using (id_provee) inner join linea using (id_linea) 
WHERE id_linea=?
order by id_linea';
  $params = array($this->linea);
  return Database::getRows($sql, $params);
}
public function proveelinea()
{
$sql = 'SELECT distinct nombre_linea from producto inner join linea using(id_linea) where id_provee=?';
  $params = array($this->proveedor);
  return Database::getRows($sql, $params);
}
//graficas
public function productosMasVendidos()
{
    $sql = 'SELECT sum(cantidad) as cantidad, nombre_producto
            from detalle_pedido inner join producto using (id_producto)
            group by nombre_producto order by cantidad desc
            limit 5';
    $params = null;
    return Database::getRows($sql, $params);
}

public function cantidadProductoPresentacion()
{
    $sql = 'SELECT count(*) as producto, presentacio
            from producto inner join presentacion using(id_presentacion)
            group by presentacio order by producto desc
            limit 5';
    $params = null;
    return Database::getRows($sql, $params);
}
public function cantidadProductosProveedor()
 {
     $sql = 'SELECT count(*) as productos, nombre
     from producto inner join proveedor using (id_provee)
     group by nombre order by productos';
     $params = null;
     return Database::getRows($sql, $params);
 }
 public function productolineagraf()
 {
     $sql = 'SELECT count(*) as producto,nombre_linea
	 from producto inner join linea  using (id_linea)
	 group by nombre_linea order by producto';
     $params = null;
     return Database::getRows($sql, $params);
 }
}
