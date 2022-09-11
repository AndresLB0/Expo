<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../modelos/productos.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $productos = new Productos;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_personal'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $productos->readAll()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = $productos->validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $productos->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Valor encontrado';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = $productos->validateForm($_POST);
                if (!$productos->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$productos->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$productos->setPrecioFactu($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!$productos->setProvee($_POST['proveedor'])) {
                    $result['exception'] = 'Precio incorrecto';
                }elseif (!$productos->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif ($productos->createRow()) {
                    $result['status'] = 1;
                        $result['message'] = 'productos creado correctamente';
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
            case 'readOne':
                if (!$productos->setIdProducto($_POST['id'])) {
                    $result['exception'] = 'productos incorrecto';
                } elseif ($result['dataset'] = $productos->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'productos inexistente';
                }
                break;
            case 'update':
                $_POST = $productos->validateForm($_POST);
                if (!$productos->setIdProducto($_POST['id'])) {
                    $result['exception'] = 'productos incorrecto';
                } elseif (!$data = $productos->readOne()) {
                    $result['exception'] = 'productos inexistente';
                } elseif (!$productos->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$productos->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$productos->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!$productos->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$productos->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    if ($productos->updateRow($data['imagen_productos'])) {
                        $result['status'] = 1;
                        $result['message'] = 'productos modificado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$productos->setImagen($_FILES['archivo'])) {
                    $result['exception'] = $productos->getFileError();
                } elseif ($productos->updateRow($data['imagen_productos'])) {
                    $result['status'] = 1;
                    if ($productos->saveFile($_FILES['archivo'], $productos->getRuta(), $productos->getImagen())) {
                        $result['message'] = 'productos modificado correctamente';
                    } else {
                        $result['message'] = 'productos modificado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$productos->setIdProducto($_POST['id'])) {
                    $result['exception'] = 'productos incorrecto';
                } elseif (!$data = $productos->readOne()) {
                    $result['exception'] = 'productos inexistente';
                } elseif ($productos->deleteRow()) {
                    $result['status'] = 1;
                    if ($productos->deleteFile($productos->getRuta(), $data['imagen_productos'])) {
                        $result['message'] = 'productos eliminado correctamente';
                    } else {
                        $result['message'] = 'productos eliminado pero no se borró la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                case 'ClientesPedidos':
                    if ($result['dataset']= $clientes->ClientesPedidos()){
                        $result['status'] = 1;
                    }else{
                        $result['exception'] = 'No hay datos disponibles';
                    }
                    break;
            case 'productosMasVendidos':
                if ($result['dataset'] = $productos->productosMasVendidos()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
            case 'cantidadProductoPresentacion':
                if ($result['dataset'] = $productos->cantidadProductoPresentacion()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
                case 'cantidadProductosProveedor':
                    if ($result['dataset'] = $productos->cantidadProductosProveedor()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No hay datos disponibles';
                    }
                    break;
                    case 'productolineagraf':
                        if ($result['dataset'] = $productos->productolineagraf()) {
                            $result['status'] = 1;
                        } else {
                            $result['exception'] = 'No hay datos disponibles';
                        }
                        break;

            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}
