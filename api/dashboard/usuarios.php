<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../modelos/personal.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $personal = new Personal;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_personal'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'getUser':
                if (isset($_SESSION['usuario'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['usuario'];
                } else {
                    $result['exception'] = 'Usuario de personal indefinido';
                }
                break;
            case 'logOut':
                if (session_destroy()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesión eliminada correctamente';
                } else {
                    $result['exception'] = 'Ocurrió un problema al cerrar la sesión';
                }
                break;
            case 'readProfile':
                if ($result['dataset'] = $personal->readProfile()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'personal inexistente';
                }
                break;
                case 'readAll':
                    if ($result['dataset'] = $personal->readAll()) {
                        $result['status'] = 1;
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No existen categorías para mostrar';
                    }
                    break;
            case 'editProfile':
                $_POST = $personal->validateForm($_POST);
                if (!$personal->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$personal->setEmail($_POST['correo'])) {
                    $result['exception'] = 'correo incorrecto';
                } elseif ($personal->editProfile()) {
                    $result['status'] = 1;
                    $result['message'] = 'Perfil modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'changePassword':
                $_POST = $personal->validateForm($_POST);
                if (!$personal->setId($_SESSION['id_personal'])) {
                    $result['exception'] = 'personal incorrecto';
                } elseif (!$personal->checkPassword($_POST['actual'])) {
                    $result['exception'] = 'Clave actual incorrecta';
                } elseif ($_POST['nueva'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves nuevas diferentes';
                } elseif (!$personal->setClave($_POST['nueva'])) {
                    $result['exception'] = $personal->getPasswordError();
                } elseif ($personal->changePassword()) {
                    $result['status'] = 1;
                    $result['message'] = 'Contraseña cambiada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'search':
                $_POST = $personal->validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $personal->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Valor encontrado';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = $personal->validateForm($_POST);
                if (!$personal->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombres incorrectos';
                }  elseif (!$personal->setEmail($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$personal->setUsuario($_POST['usuario'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif (!$personal->setDUI($_POST['dui'])) {
                    $result['exception'] = 'DUI incorrecto';
                }elseif (!$personal->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Telefono incorrecto';
                }elseif (!$personal->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Telefono incorrecto';
                }elseif (!$personal->setCargo($_POST['cargo'])) {
                    $result['exception'] = 'Cargo incorrecto';
                }elseif ($_POST['clave'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves diferentes';
                } elseif (!$personal->setClave($_POST['clave'])) {
                    $result['exception'] = $personal->getPasswordError();
                } elseif ($personal->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'personal creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOne':
                if (!$personal->setId($_POST['id'])) {
                    $result['exception'] = 'personal incorrecto';
                } elseif ($result['dataset'] = $personal->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'personal inexistente';
                }
                break;
            case 'update':
                $_POST = $personal->validateForm($_POST);
                if (!$personal->setId($_POST['id'])) {
                    $result['exception'] = 'personal incorrecto';
                } elseif (!$personal->readOne()) {
                    $result['exception'] = 'personal inexistente';
                } elseif (!$personal->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombres incorrectos';
                }  elseif (!$personal->setEmail($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif ($personal->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'personal modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if ($_POST['id'] == $_SESSION['id_personal']) {
                    $result['exception'] = 'No se puede eliminar a sí mismo';
                } elseif (!$personal->setId($_POST['id'])) {
                    $result['exception'] = 'personal incorrecto';
                } elseif (!$personal->readOne()) {
                    $result['exception'] = 'personal inexistente';
                } elseif ($personal->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'personal eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //graficos
            case 'cantidadPedidosZona':
                if ($result['dataset']= $personal->cantidadPedidosZona()){
                    $result['status'] = 1;
                }else{
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
                case 'cantidadPersonalCargo':
                    if ($result['dataset'] = $personal->cantidadPersonalCargo()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No hay datos disponibles';
                    }
                    break;
                   
            default:case 'cantidadPedidosPersonal':
                if ($result['dataset'] = $personal->cantidadPedidosPersonal()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando el administrador no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readUsers':
                if ($personal->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existe al menos un personal registrado';
                } else {
                    $result['exception'] = 'No existen personal registrados';
                }
                break;
            case 'register':
                $_POST = $personal->validateForm($_POST);
                if (!$personal->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$personal->setEmail($_POST['correo'])) {
                    $result['exception'] = 'correo incorrecto';
                } elseif (!$personal->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'correo incorrecto';
                }elseif (!$personal->setUsuario($_POST['usuario'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif ($_POST['clave'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves diferentes';
                } elseif (!$personal->setClave($_POST['clave'])) {
                    $result['exception'] = $personal->getPasswordError();
                } elseif ($personal->registro()) {
                    $result['status'] = 1;
                    $result['message'] = 'usuario registrado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'logIn':
                $_POST = $personal->validateForm($_POST);
                if (!$personal->checkUser($_POST['usuario'])) {
                    $result['exception'] = 'Usuario o Contraseña incorrectos';
                } elseif ($personal->checkPassword($_POST['clave'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Autenticación correcta';
                    $_SESSION['id_personal'] = $personal->getId();
                    $_SESSION['usuario'] = $personal->getUsuario();
                } else {
                    $result['exception'] = 'Usuario o Contraseña incorectos';
                }
                break;
           // default:
                $result['exception'] = 'Acción no disponible fuera de la sesión';
        }
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
