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
                if ($_POST['searchbar'] == '') {
                    $result['dataset'] = $cargo->readAll();
                    $result['status'] = 1;
                } elseif ($result['dataset'] = $cargo->searchRows($_POST['searchbar'])) {
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
                }elseif (!isset($_POST['paginas'])) {
                    $result['exception'] = 'no pude asignar 0 permisos';
                } elseif ($cargo->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cargo creado correctamente';
                    $GLOBALS['paginas'] = $_POST['paginas'];
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
            case 'readOne':
                if (!$cargo->setID($_POST['idup'])) {
                    $result['exception'] = 'Cargo incorrecto';
                } elseif ($result['dataset'] = $cargo->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Cargo inexistente';
                }
                break;
            case 'update':
                $_POST = $cargo->validateForm($_POST);
                if (!$cargo->setId($_POST['idup'])) {
                    $result['exception'] = 'cargo incorrecto';
                } elseif (!$cargo->readOne()) {
                    $result['exception'] = 'cargo inexistente';
                } elseif (!$cargo->setNombre($_POST['nombreup'])) {
                    $result['exception'] = 'Nombre incorrecto';
                }elseif ($cargo->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'cargo modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$cargo->setId($_POST['id'])) {
                    $result['exception'] = 'Cargo incorrecto';
                } elseif (!$data = $cargo->readOne()) {
                    $result['exception'] = 'Cargo inexistente';
                } elseif ($cargo->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cargo eliminado correctamente';
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
