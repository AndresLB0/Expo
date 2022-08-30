<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../modelos/linea.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $linea = new linea;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario']) or true) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $linea->readAll()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = $linea->validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $linea->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Valor encontrado';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = $linea->validateForm($_POST);
                if (!$linea->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$linea->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$linea->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!isset($_POST['categoria'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$linea->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Categoría incorrecta';
                } elseif (!$linea->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!$linea->setImagen($_FILES['archivo'])) {
                    $result['exception'] = $linea->getFileError();
                } elseif ($linea->createRow()) {
                    $result['status'] = 1;
                    if ($linea->saveFile($_FILES['archivo'], $linea->getRuta(), $linea->getImagen())) {
                        $result['message'] = 'linea creado correctamente';
                    } else {
                        $result['message'] = 'linea creado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
            case 'readOne':
                if (!$linea->setID($_POST['id'])) {
                    $result['exception'] = 'linea incorrecto';
                } elseif ($result['dataset'] = $linea->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'linea inexistente';
                }
                break;
            case 'update':
                $_POST = $linea->validateForm($_POST);
                if (!$linea->setID($_POST['id'])) {
                    $result['exception'] = 'linea incorrecto';
                } elseif (!$data = $linea->readOne()) {
                    $result['exception'] = 'linea inexistente';
                } elseif (!$linea->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$linea->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$linea->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!$linea->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$linea->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    if ($linea->updateRow($data['imagen_linea'])) {
                        $result['status'] = 1;
                        $result['message'] = 'linea modificado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$linea->setImagen($_FILES['archivo'])) {
                    $result['exception'] = $linea->getFileError();
                } elseif ($linea->updateRow($data['imagen_linea'])) {
                    $result['status'] = 1;
                    if ($linea->saveFile($_FILES['archivo'], $linea->getRuta(), $linea->getImagen())) {
                        $result['message'] = 'linea modificado correctamente';
                    } else {
                        $result['message'] = 'linea modificado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$linea->setID($_POST['id'])) {
                    $result['exception'] = 'linea incorrecto';
                } elseif (!$data = $linea->readOne()) {
                    $result['exception'] = 'linea inexistente';
                } elseif ($linea->deleteRow()) {
                    $result['status'] = 1;
                    if ($linea->deleteFile($linea->getRuta(), $data['imagen_linea'])) {
                        $result['message'] = 'linea eliminado correctamente';
                    } else {
                        $result['message'] = 'linea eliminado pero no se borró la imagen';
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
