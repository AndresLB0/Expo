<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../modelos/envio.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $envio = new envio;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario']) or true) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $envio->readAll()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = $envio->validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $envio->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Valor encontrado';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = $envio->validateForm($_POST);
                if (!$envio->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$envio->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$envio->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!isset($_POST['categoria'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$envio->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Categoría incorrecta';
                } elseif (!$envio->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!$envio->setImagen($_FILES['archivo'])) {
                    $result['exception'] = $envio->getFileError();
                } elseif ($envio->createRow()) {
                    $result['status'] = 1;
                    if ($envio->saveFile($_FILES['archivo'], $envio->getRuta(), $envio->getImagen())) {
                        $result['message'] = 'envio creado correctamente';
                    } else {
                        $result['message'] = 'envio creado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
            case 'readOne':
                if (!$envio->setID($_POST['id'])) {
                    $result['exception'] = 'envio incorrecto';
                } elseif ($result['dataset'] = $envio->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'envio inexistente';
                }
                break;
            case 'update':
                $_POST = $envio->validateForm($_POST);
                if (!$envio->setID($_POST['id'])) {
                    $result['exception'] = 'envio incorrecto';
                } elseif (!$data = $envio->readOne()) {
                    $result['exception'] = 'envio inexistente';
                } elseif (!$envio->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$envio->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$envio->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!$envio->setCategoria($_POST['categoria'])) {
                    $result['exception'] = 'Seleccione una categoría';
                } elseif (!$envio->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    if ($envio->updateRow($data['imagen_envio'])) {
                        $result['status'] = 1;
                        $result['message'] = 'envio modificado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$envio->setImagen($_FILES['archivo'])) {
                    $result['exception'] = $envio->getFileError();
                } elseif ($envio->updateRow($data['imagen_envio'])) {
                    $result['status'] = 1;
                    if ($envio->saveFile($_FILES['archivo'], $envio->getRuta(), $envio->getImagen())) {
                        $result['message'] = 'envio modificado correctamente';
                    } else {
                        $result['message'] = 'envio modificado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$envio->setID($_POST['id'])) {
                    $result['exception'] = 'envio incorrecto';
                } elseif (!$data = $envio->readOne()) {
                    $result['exception'] = 'envio inexistente';
                } elseif ($envio->deleteRow()) {
                    $result['status'] = 1;
                    if ($envio->deleteFile($envio->getRuta(), $data['imagen_envio'])) {
                        $result['message'] = 'envio eliminado correctamente';
                    } else {
                        $result['message'] = 'envio eliminado pero no se borró la imagen';
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
