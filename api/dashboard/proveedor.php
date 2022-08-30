<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../modelos/proveedores.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $proveedores = new proveedor;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario']) or true) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $proveedores->readAll()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = $proveedores->validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $proveedores->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Valor encontrado';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = $proveedores->validateForm($_POST);
                if (!$proveedores->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$proveedores->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$proveedores->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!isset($_POST['categoria'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$proveedores->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Categoría incorrecta';
                } elseif (!$proveedores->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!$proveedores->setImagen($_FILES['archivo'])) {
                    $result['exception'] = $proveedores->getFileError();
                } elseif ($proveedores->createRow()) {
                    $result['status'] = 1;
                    if ($proveedores->saveFile($_FILES['archivo'], $proveedores->getRuta(), $proveedores->getImagen())) {
                        $result['message'] = 'proveedores creado correctamente';
                    } else {
                        $result['message'] = 'proveedores creado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
            case 'readOne':
                if (!$proveedores->setID($_POST['id'])) {
                    $result['exception'] = 'proveedores incorrecto';
                } elseif ($result['dataset'] = $proveedores->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'proveedores inexistente';
                }
                break;
            case 'update':
                $_POST = $proveedores->validateForm($_POST);
                if (!$proveedores->setID($_POST['id'])) {
                    $result['exception'] = 'proveedores incorrecto';
                } elseif (!$data = $proveedores->readOne()) {
                    $result['exception'] = 'proveedores inexistente';
                } elseif (!$proveedores->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$proveedores->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$proveedores->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!$proveedores->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$proveedores->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    if ($proveedores->updateRow($data['imagen_proveedores'])) {
                        $result['status'] = 1;
                        $result['message'] = 'proveedores modificado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$proveedores->setImagen($_FILES['archivo'])) {
                    $result['exception'] = $proveedores->getFileError();
                } elseif ($proveedores->updateRow($data['imagen_proveedores'])) {
                    $result['status'] = 1;
                    if ($proveedores->saveFile($_FILES['archivo'], $proveedores->getRuta(), $proveedores->getImagen())) {
                        $result['message'] = 'proveedores modificado correctamente';
                    } else {
                        $result['message'] = 'proveedores modificado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$proveedores->setID($_POST['id'])) {
                    $result['exception'] = 'proveedores incorrecto';
                } elseif (!$data = $proveedores->readOne()) {
                    $result['exception'] = 'proveedores inexistente';
                } elseif ($proveedores->deleteRow()) {
                    $result['status'] = 1;
                    if ($proveedores->deleteFile($proveedores->getRuta(), $data['imagen_proveedores'])) {
                        $result['message'] = 'proveedores eliminado correctamente';
                    } else {
                        $result['message'] = 'proveedores eliminado pero no se borró la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
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
