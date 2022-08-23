<?php
/*
*	Clase para manejar la tabla productos de la base de datos.
*   Es clase hija de Validator.
*/
class Productos extends Validator
{
    // Declaración de atributos (propiedades).
    private $id_producto = null;
    private $id_lote = null;
    private $nombre = null;
    private $descripcion = null;
    private $precio_fact = null;
    private $precio_iva = null;
    private $proveedor = null;
    private $presentacion = null;
    private $linea = null;
    private $descuento = null;
    private $reg_sanitario = null;
    private $tamanio = null;
    private $estado = null;
    private $existencias=null;

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setIdProducto($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id_producto = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setIdLote($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id_lote = $value;
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
    public function setPresentacion($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->presentacion = $value;
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
    public function setLinea($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->linea = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setEstado($value)
    {
        if ($this->validateBoolean($value)) {
            $this->estado = $value;
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
        if ($this->validateDesc($value)) {
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
    

    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getIdProducto()
    {
        return $this->id_producto;
    }
    public function getIdLote()
    {
        return $this->id_lote;
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
    public function getLinea()
    {
        return $this->linea;
    }
    public function getEstado()
    {
        return $this->estado;
    }
    public function getExistencias()
    {
        return $this->existencias;
    }
    public function getPresentacion()
    {
        return $this->presentacion;
    }
    public function getDescuento()
    {
        return $this->descuento;
    }
    public function getRegsan()
    {
        return $this->Reg_sanitario;
    }
    public function getTamanio()
    {
        return $this->tamanio;
    }

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_producto, nombre_producto, descripcion, precio_fact,precio_iva,presentacio,nombre,nombre_linea,existencias, estado_producto
                FROM producto INNER JOIN proveedor USING(id_provee) INNER join presentacion using(id_presentacion)
                WHERE nombre_producto ILIKE ? OR descripcion_producto ILIKE ?
                ORDER BY nombre_producto';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO producto(nombre_producto, descripcion_producto, precio_producto, imagen_producto, estado_producto, id_provee, id_usuario)
                VALUES(?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->descripcion, $this->precio, $this->imagen, $this->estado, $this->proveedor, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_producto, imagen_producto, nombre_producto, descripcion_producto, precio_producto, nombre,existencias,presentacion, estado_producto
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

    public function updateRow($current_image)
    {
        // Se verifica si existe una nueva imagen para borrar la actual, de lo contrario se mantiene la actual.
        ($this->imagen) ? $this->deleteFile($this->getRuta(), $current_image) : $this->imagen = $current_image;

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
    *   Métodos para generar gráficas.
    */
    public function productosmasvendidos()
    {
        $sql = 'SELECT sum(cantidad) as cantidad, nombre_producto
        from detalle_pedido inner join producto using (id_producto)
        group by nombre_producto order by cantidad desc
        limit 5';
        $params = null;
        return Database::getRows($sql, $params);
    }

    /*
    *   Métodos para generar reportes.
    */
    
}
