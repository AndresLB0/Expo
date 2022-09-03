<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../modelos/institucion.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $institucion = new institucion;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_personal'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $institucion->readAll()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = $institucion->validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $institucion->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Valor encontrado';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = $institucion->validateForm($_POST);
                if (!$institucion->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$institucion->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$institucion->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!isset($_POST['categoria'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$institucion->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Categoría incorrecta';
                } elseif (!$institucion->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!$institucion->setImagen($_FILES['archivo'])) {
                    $result['exception'] = $institucion->getFileError();
                } elseif ($institucion->createRow()) {
                    $result['status'] = 1;
                    if ($institucion->saveFile($_FILES['archivo'], $institucion->getRuta(), $institucion->getImagen())) {
                        $result['message'] = 'institucion creado correctamente';
                    } else {
                        $result['message'] = 'institucion creado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
            case 'readOne':
                if (!$institucion->setID($_POST['id'])) {
                    $result['exception'] = 'institucion incorrecto';
                } elseif ($result['dataset'] = $institucion->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'institucion inexistente';
                }
                break;
            case 'update':
                $_POST = $institucion->validateForm($_POST);
                if (!$institucion->setID($_POST['id'])) {
                    $result['exception'] = 'institucion incorrecto';
                } elseif (!$data = $institucion->readOne()) {
                    $result['exception'] = 'institucion inexistente';
                } elseif (!$institucion->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$institucion->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$institucion->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!$institucion->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$institucion->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    if ($institucion->updateRow($data['imagen_institucion'])) {
                        $result['status'] = 1;
                        $result['message'] = 'institucion modificado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$institucion->setImagen($_FILES['archivo'])) {
                    $result['exception'] = $institucion->getFileError();
                } elseif ($institucion->updateRow($data['imagen_institucion'])) {
                    $result['status'] = 1;
                    if ($institucion->saveFile($_FILES['archivo'], $institucion->getRuta(), $institucion->getImagen())) {
                        $result['message'] = 'institucion modificado correctamente';
                    } else {
                        $result['message'] = 'institucion modificado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$institucion->setID($_POST['id'])) {
                    $result['exception'] = 'institucion incorrecto';
                } elseif (!$data = $institucion->readOne()) {
                    $result['exception'] = 'institucion inexistente';
                } elseif ($institucion->deleteRow()) {
                    $result['status'] = 1;
                    if ($institucion->deleteFile($institucion->getRuta(), $data['imagen_institucion'])) {
                        $result['message'] = 'institucion eliminado correctamente';
                    } else {
                        $result['message'] = 'institucion eliminado pero no se borró la imagen';
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
