<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../modelos/especialidad.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $especi = new especialidad;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_personal'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $especi->readAll()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = $especi->validateForm($_POST);
                if ($_POST['searchbar'] == '') {
                    $result['dataset'] = $especi->readAll();
                    $result['status'] = 1;
                } elseif ($result['dataset'] = $especi->searchRows($_POST['searchbar'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Valor encontrado';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = $especi->validateForm($_POST);
                if (!$especi->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                }elseif ($especi->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'especi creado correctamente';
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
            case 'readOne':
                if (!$especi->setID($_POST['idup'])) {
                    $result['exception'] = 'especi incorrecto';
                } elseif ($result['dataset'] = $especi->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'especi inexistente';
                }
                break;
            case 'update':
                $_POST = $especi->validateForm($_POST);
                if (!$especi->setId($_POST['idup'])) {
                    $result['exception'] = 'especi incorrecto';
                } elseif (!$especi->readOne()) {
                    $result['exception'] = 'especi inexistente';
                } elseif (!$especi->setNombre($_POST['nombreup'])) {
                    $result['exception'] = 'Nombre incorrecto';
                }elseif ($especi->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'especi modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$especi->setId($_POST['id'])) {
                    $result['exception'] = 'especi incorrecto';
                } elseif (!$data = $especi->readOne()) {
                    $result['exception'] = 'especi inexistente';
                } elseif ($especi->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'especi eliminado correctamente';
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
