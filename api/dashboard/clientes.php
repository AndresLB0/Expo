<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../modelos/clientes.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $clientes = new Clientes;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'recaptcha' => 0, 'message' => null, 'exception' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como clientes para realizar las acciones correspondientes.
    if (isset($_SESSION['id_usuario'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un clientes ha iniciado sesión.
        switch ($_GET['action']) {
            case 'getUser':
                if (isset($_SESSION['correo_clientes'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['correo_clientes'];
                } else {
                    $result['exception'] = 'Correo de usuario indefinido';
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
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando el clientes no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'register':
                $_POST = $clientes->validateForm($_POST);
                $secretKey = '6LdBzLQUAAAAAL6oP4xpgMao-SmEkmRCpoLBLri-';
                $ip = $_SERVER['REMOTE_ADDR'];

                $data = array('secret' => $secretKey, 'response' => $_POST['g-recaptcha-response'],'remoteip' => $ip);

                $options = array(
                    'http' => array('header'  => "Content-type: application/x-www-form-urlencoded\r\n", 'method' => 'POST', 'content' => http_build_query($data)),
                    'ssl' => array('verify_peer' => false, 'verify_peer_name' => false)
                );

                $url = 'https://www.google.com/recaptcha/api/siteverify';
                $context  = stream_context_create($options);
                $response = file_get_contents($url, false, $context);
                $captcha = json_decode($response, true);

                if (!$captcha['success']) {
                    $result['recaptcha'] = 1;
                    $result['exception'] = 'No eres un humano';
                } elseif (!$clientes->setNombres($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$clientes->setApellidos($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$clientes->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$clientes->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Dirección incorrecta';
                } elseif (!$clientes->setDUI($_POST['dui'])) {
                    $result['exception'] = 'DUI incorrecto';
                } elseif (!$clientes->setNacimiento($_POST['nacimiento'])) {
                    $result['exception'] = 'Fecha de nacimiento incorrecta';
                } elseif (!$clientes->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Teléfono incorrecto';
                } elseif ($_POST['clave'] != $_POST['confirmar_clave']) {
                    $result['exception'] = 'Claves diferentes';
                } elseif (!$clientes->setClave($_POST['clave'])) {
                    $result['exception'] = $clientes->getPasswordError();
                } elseif ($clientes->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'clientes registrado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'logIn':
                $_POST = $clientes->validateForm($_POST);
                if (!$clientes->checkUser($_POST['usuario'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$clientes->getEstado()) {
                    $result['exception'] = 'La cuenta ha sido desactivada';
                } elseif ($clientes->checkPassword($_POST['clave'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Autenticación correcta';
                    $_SESSION['id_clientes'] = $clientes->getId();
                    $_SESSION['correo_clientes'] = $clientes->getCorreo();
                } else {
                    $result['exception'] = 'Clave incorrecta';
                }
                break;
            case 'ClientesPedidos':
                    if ($result['dataset']= $clientes->ClientesPedidos()){
                        $result['status'] = 1;
                    }else{
                        $result['exception'] = 'No hay datos disponibles';
                    }
                    break;
            default:
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
