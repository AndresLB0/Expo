<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../modelos/zona.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $zona = new zona;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_personal'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $zona->readAll()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = $zona->validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $zona->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Valor encontrado';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
                case 'create':
                    $_POST = $zona->validateForm($_POST);
                    if (!$zona->setNombre($_POST['zona'])) {
                        $result['exception'] = 'Nombre incorrecto';
                    } elseif ($zona->createRow()) {
                        $result['status'] = 1;
                            $result['message'] = 'zona creado correctamente';
                    } else {
                        $result['exception'] = Database::getException();;
                    }
                    break;
            case 'readOne':
                if (!$zona->setID($_POST['id'])) {
                    $result['exception'] = 'zona incorrecto';
                } elseif ($result['dataset'] = $zona->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'zona inexistente';
                }
                break;
            case 'update':
                $_POST = $zona->validateForm($_POST);
                if (!$zona->setID($_POST['id'])) {
                    $result['exception'] = 'zona incorrecto';
                } elseif (!$data = $zona->readOne()) {
                    $result['exception'] = 'zona inexistente';
                } elseif (!$zona->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$zona->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$zona->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!$zona->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$zona->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    if ($zona->updateRow($data['imagen_zona'])) {
                        $result['status'] = 1;
                        $result['message'] = 'zona modificado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$zona->setImagen($_FILES['archivo'])) {
                    $result['exception'] = $zona->getFileError();
                } elseif ($zona->updateRow($data['imagen_zona'])) {
                    $result['status'] = 1;
                    if ($zona->saveFile($_FILES['archivo'], $zona->getRuta(), $zona->getImagen())) {
                        $result['message'] = 'zona modificado correctamente';
                    } else {
                        $result['message'] = 'zona modificado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$zona->setID($_POST['id'])) {
                    $result['exception'] = 'zona incorrecto';
                } elseif (!$data = $zona->readOne()) {
                    $result['exception'] = 'zona inexistente';
                } elseif ($zona->deleteRow()) {
                    $result['status'] = 1;
                    if ($zona->deleteFile($zona->getRuta(), $data['imagen_zona'])) {
                        $result['message'] = 'zona eliminado correctamente';
                    } else {
                        $result['message'] = 'zona eliminado pero no se borró la imagen';
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
