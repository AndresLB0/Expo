<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../modelos/cargos.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $cargo = new cargos;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_personal'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $cargo->readAll()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = $cargo->validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $cargo->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Valor encontrado';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = $cargo->validateForm($_POST);
                if (!$cargo->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$cargo->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$cargo->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!isset($_POST['categoria'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$cargo->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Categoría incorrecta';
                } elseif (!$cargo->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                }  elseif ($cargo->createRow()) {
                    $result['status'] = 1;
                    if ($cargo->saveFile($_FILES['archivo'], $cargo->getRuta(), $cargo->getImagen())) {
                        $result['message'] = 'cargo creado correctamente';
                    } else {
                        $result['message'] = 'cargo creado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
            case 'readOne':
                if (!$cargo->setID($_POST['id'])) {
                    $result['exception'] = 'cargo incorrecto';
                } elseif ($result['dataset'] = $cargo->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'cargo inexistente';
                }
                break;
            case 'update':
                $_POST = $cargo->validateForm($_POST);
                if (!$cargo->setID($_POST['id'])) {
                    $result['exception'] = 'cargo incorrecto';
                } elseif (!$data = $cargo->readOne()) {
                    $result['exception'] = 'cargo inexistente';
                } elseif (!$cargo->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$cargo->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$cargo->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!$cargo->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$cargo->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    if ($cargo->updateRow($data['imagen_cargo'])) {
                        $result['status'] = 1;
                        $result['message'] = 'cargo modificado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$cargo->setImagen($_FILES['archivo'])) {
                    $result['exception'] = $cargo->getFileError();
                } elseif ($cargo->updateRow($data['imagen_cargo'])) {
                    $result['status'] = 1;
                    if ($cargo->saveFile($_FILES['archivo'], $cargo->getRuta(), $cargo->getImagen())) {
                        $result['message'] = 'cargo modificado correctamente';
                    } else {
                        $result['message'] = 'cargo modificado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$cargo->setID($_POST['id'])) {
                    $result['exception'] = 'cargo incorrecto';
                } elseif (!$data = $cargo->readOne()) {
                    $result['exception'] = 'cargo inexistente';
                } elseif ($cargo->deleteRow()) {
                    $result['status'] = 1;
                    if ($cargo->deleteFile($cargo->getRuta(), $data['imagen_cargo'])) {
                        $result['message'] = 'cargo eliminado correctamente';
                    } else {
                        $result['message'] = 'cargo eliminado pero no se borró la imagen';
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
