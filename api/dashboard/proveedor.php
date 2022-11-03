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
    if (isset($_SESSION['id_personal'])) {
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
                    } elseif (!$proveedores->setContacto($_POST['contacto'])) {
                        $result['exception'] = 'Nombre de contacto incorrecto';
                    }elseif (!$proveedores->setTelefono($_POST['telefono'])) {
                        $result['exception'] = 'Telefono incorrecto';
                    }elseif ($proveedores->createRow()) {
                        $result['status'] = 1;
                            $result['message'] = 'Proveedor creado correctamente';
                    } else {
                        $result['exception'] = Database::getException();;
                    }
                    break;
            case 'readOne':
                if (!$proveedores->setID($_POST['idup'])) {
                    $result['exception'] = 'Proveedores incorrectos';
                } elseif ($result['dataset'] = $proveedores->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Proveedores inexistentes';
                }
                break;
                case 'update':
                    $_POST = $proveedores->validateForm($_POST);
                    if (!$proveedores->setId($_POST['idup'])) {
                        $result['exception'] = 'proveedores incorrecto';
                    } elseif (!$proveedores->readOne()) {
                        $result['exception'] = 'proveedores inexistente';
                    } elseif (!$proveedores->setNombre($_POST['nombreup'])) {
                        $result['exception'] = 'Nombre incorrecto';
                    } elseif (!$proveedores->setContacto($_POST['contactoup'])) {
                        $result['exception'] = 'Nombre de contacto incorrecto';
                    }elseif (!$proveedores->setTelefono($_POST['telefonoup'])) {
                        $result['exception'] = 'Telefono incorrecto';
                    }  elseif ($proveedores->updateRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'proveedores modificado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                    break;
            case 'delete':
                if (!$proveedores->setID($_POST['id'])) {
                    $result['exception'] = 'Proveedores incorrectos';
                } elseif (!$data = $proveedores->readOne()) {
                    $result['exception'] = 'Proveedores inexistentes';
                } elseif ($proveedores->deleteRow()) {
                    $result['status'] = 1;
                    if ($proveedores->deleteFile($proveedores->getRuta(), $data['imagen_proveedores'])) {
                        $result['message'] = 'Proveedores eliminados correctamente';
                    } else {
                        $result['message'] = 'Proveedores eliminados pero no se borró la imagen';
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
