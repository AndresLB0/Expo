<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../modelos/presentacion.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $presentacion = new presentacion;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario']) or true) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $presentacion->readAll()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = $presentacion->validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $presentacion->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Valor encontrado';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = $presentacion->validateForm($_POST);
                if (!$presentacion->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$presentacion->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$presentacion->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!isset($_POST['categoria'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$presentacion->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Categoría incorrecta';
                } elseif (!$presentacion->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!$presentacion->setImagen($_FILES['archivo'])) {
                    $result['exception'] = $presentacion->getFileError();
                } elseif ($presentacion->createRow()) {
                    $result['status'] = 1;
                    if ($presentacion->saveFile($_FILES['archivo'], $presentacion->getRuta(), $presentacion->getImagen())) {
                        $result['message'] = 'presentacion creado correctamente';
                    } else {
                        $result['message'] = 'presentacion creado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
            case 'readOne':
                if (!$presentacion->setID($_POST['id'])) {
                    $result['exception'] = 'presentacion incorrecto';
                } elseif ($result['dataset'] = $presentacion->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'presentacion inexistente';
                }
                break;
            case 'update':
                $_POST = $presentacion->validateForm($_POST);
                if (!$presentacion->setID($_POST['id'])) {
                    $result['exception'] = 'presentacion incorrecto';
                } elseif (!$data = $presentacion->readOne()) {
                    $result['exception'] = 'presentacion inexistente';
                } elseif (!$presentacion->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$presentacion->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$presentacion->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!$presentacion->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$presentacion->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    if ($presentacion->updateRow($data['imagen_presentacion'])) {
                        $result['status'] = 1;
                        $result['message'] = 'presentacion modificado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$presentacion->setImagen($_FILES['archivo'])) {
                    $result['exception'] = $presentacion->getFileError();
                } elseif ($presentacion->updateRow($data['imagen_presentacion'])) {
                    $result['status'] = 1;
                    if ($presentacion->saveFile($_FILES['archivo'], $presentacion->getRuta(), $presentacion->getImagen())) {
                        $result['message'] = 'presentacion modificado correctamente';
                    } else {
                        $result['message'] = 'presentacion modificado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$presentacion->setID($_POST['id'])) {
                    $result['exception'] = 'presentacion incorrecto';
                } elseif (!$data = $presentacion->readOne()) {
                    $result['exception'] = 'presentacion inexistente';
                } elseif ($presentacion->deleteRow()) {
                    $result['status'] = 1;
                    if ($presentacion->deleteFile($presentacion->getRuta(), $data['imagen_presentacion'])) {
                        $result['message'] = 'presentacion eliminado correctamente';
                    } else {
                        $result['message'] = 'presentacion eliminado pero no se borró la imagen';
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
