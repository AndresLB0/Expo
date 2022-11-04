<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../modelos/personal.php');
require_once('correos.php');
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $personal = new Personal;
    $vali = new Validator;

    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0,'permiso'=>0, 'session' => 0,'noventa'=>0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_personal'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'getUser':
                if (!isset($_SESSION['usuario'])) {
                    $result['exception'] = 'Usuario de personal indefinido';
                }elseif (!$personal->checkToken($_SESSION['token'])) {
                    $result['exception'] = 'esta sesion ya estaba iniciada en otro dispositivo';
                } else{
                    # code...
                    $result['permiso'] = 1;
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['usuario'];
                }
                break;
            case 'logOut':
                if (session_destroy()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesión eliminada correctamente';
                    $personal->deleteToken(); 
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
                    $result['exception'] = 'Personal inexistente';
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
                if (!$personal->setNombre($_POST['nombres'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$personal->setDUI($_POST['dui'])) {
                    $result['exception'] = 'dui incorrecto';
                }elseif (!$personal->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Telefono incorrecto';
                }elseif (!$personal->setEmail($_POST['correo'])) {
                    $result['exception'] = 'correo incorrecto';
                } elseif (!$personal->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'direccion incorrecta';
                }elseif ($personal->editProfile()) {
                    $result['status'] = 1;
                    $result['message'] = 'Perfil modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'changePassword':
                $_POST = $personal->validateForm($_POST);
                if (!$personal->setId($_SESSION['id_personal'])) {
                    $result['exception'] = 'Personal incorrecto';
                } elseif (!$personal->checkPassword($_POST['actual'])) {
                    $result['exception'] = 'Clave actual incorrecta';
                }elseif ($_POST['actual'] == $_POST['nueva']) {
                    $result['exception'] = 'La nueva clave no puede ser igual a la anterior';
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
                if ($_POST['searchbar'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $personal->searchRows($_POST['searchbar'])) {
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
                $data = array(
                    'secret' => "0xA9B2cff5d4CA715FF4Bf9A1945b927695198fabB",
                    'response' => $_POST['h-captcha-response']
                );
        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($verify);
        // var_dump($response);
        $responseData = json_decode($response);
   
               if (!$personal->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombres incorrectos';
                }  elseif (!$personal->setEmail($_POST['email'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$personal->setUsuario($_POST['usuario'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif (!$personal->setDUI($_POST['dui'])) {
                    $result['exception'] = 'DUI incorrecto';
                }elseif (!$personal->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Telefono incorrecto';
                }elseif (!$personal->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Direccion incorrecto';
                }elseif (!$personal->setCargo($_POST['cargo'])) {
                    $result['exception'] = 'Cargo incorrecto';
                }elseif ($_POST['clave'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves diferentes';
                } elseif (!$personal->setClave($_POST['clave'])) {
                    $result['exception'] = $personal->getPasswordError();
                } elseif(!$responseData->success) {
                    $result['exception'] = 'Usted no es humano';
                }elseif ($personal->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOne':
                if (!$personal->setId($_POST['id'])) {
                    $result['exception'] = 'Personal incorrecto';
                } elseif ($result['dataset'] = $personal->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Personal inexistente';
                }
                break;
            case 'update':
                $_POST = $personal->validateForm($_POST);
                if (!$personal->setId($_POST['id'])) {
                    $result['exception'] = 'Personal incorrecto';
                } elseif (!$personal->readOne()) {
                    $result['exception'] = 'Personal inexistente';
                } elseif (!$personal->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$personal->setDUI($_POST['dui'])) {
                    $result['exception'] = 'dui incorrecto';
                }elseif (!$personal->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Telefono incorrecto';
                }elseif (!$personal->setEmail($_POST['email'])) {
                    $result['exception'] = 'correo incorrecto';
                }elseif (!$personal->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'direccion incorrecta';
                }elseif (!$personal->setCargo($_POST['cargo'])) {
                    $result['exception'] = 'Cargo incorrecto';
                }  elseif ($personal->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Personal modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if ($_POST['id'] == $_SESSION['id_personal']) {
                    $result['exception'] = 'No se puede eliminar a sí mismo';
                } elseif (!$personal->setId($_POST['id'])) {
                    $result['exception'] = 'Personal incorrecto';
                } elseif (!$personal->readOne()) {
                    $result['exception'] = 'Personal inexistente';
                } elseif ($personal->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Personal eliminado correctamente';
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
                case 'checkToken':
                    $_POST = $personal->validateForm($_POST);
                    if (!$personal->setId($_SESSION['id_personal'])) {
                        $result['exception'] = 'Personal incorrecto';
                    }elseif (!$personal->checkToken($_POST['token'])) {
                        $result['exception'] = 'Token incorrecto';
                    }else {
                        $result['status'] = 1;
                        $result['message'] ='Token confirmado';
                        $_SESSION['token']=$personal->getToken();
                    }
                    break;
                    case 'changePswd':
                        $_POST = $personal->validateForm($_POST);
                        if (!$personal->setId($_SESSION['id_personal'])) {
                            $result['exception'] = 'Personal incorrecto';
                        }elseif (!$personal->checkPassword($_POST['actual'])) {
                            $result['exception'] = 'Clave actual incorrecta';
                        }elseif ($_POST['actual'] == $_POST['nueva']) {
                            $result['exception'] = 'La nueva clave no puede ser igual a la anterior';
                        } elseif ($_POST['nueva'] != $_POST['confirmar']) {
                            $result['exception'] = 'Claves nuevas diferentes';
                        } elseif (!$personal->setClave($_POST['nueva'])) {
                            $result['exception'] = $personal->getPasswordError();
                        } elseif ($personal->changePassword()) {
                            $result['status'] = 1;
                            $result['message'] = 'Contraseña cambiada correctamente';
                            $_SESSION['nombre'] = $personal->getNombre();
                            $_SESSION['correo'] = $personal->getEmail();
                            sendemail($_SESSION['nombre'],$_SESSION['correo'],'Auntentificacion de inicio de sesion', 'no comparta este codigo con nadie, su codigo SGVM es:');
                            $result['message'] = 'Correo eviado';
                            $personal->saveToken();
                        } else {
                            $result['exception'] = Database::getException();
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
                if (!$personal->readAll()) {
                $origin = array($_POST['nombre'], $_POST['usuario'], $_POST['correo']);
                $_POST = $personal->validateForm($_POST);
                $data = array(
                    'secret' => "0xA9B2cff5d4CA715FF4Bf9A1945b927695198fabB",
                    'response' => $_POST['h-captcha-response']
                );
        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($verify);
        // var_dump($response);
        $responseData = json_decode($response);
                if (!$personal->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$personal->setEmail($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$personal->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Telefono incorrecto';
                }elseif (!$personal->setUsuario($_POST['usuario'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif ($_POST['clave'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves diferentes';
                }elseif (!$personal->setClave($_POST['clave'])) {
                    $result['exception'] = $personal->getPasswordError();
                }elseif(!$responseData->success) {
                    $result['exception'] = 'Eres un robot';
                }//llamando a la funcion en validator para asegurarnos que los datos de los campos no coincidan con la clave
                elseif (!$vali->multihaystacks_stripos($_POST['clave'],$origin)) {
                    $result['exception'] = 'La clave tiene que ser diferente al resto de informacion';
                }elseif ($personal->registro()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario registrado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
            }else{
                $result['exception'] = 'No puede registrarse dos veces';
            }
                break;
            case 'logIn':
                $_POST = $personal->validateForm($_POST);
                if (!$personal->checkUser($_POST['usuario'])) {
                    $result['exception'] = 'Usuario o Contraseña incorrectosl';   
                }elseif ($personal->getIntentos() >3) {
                        $result['exception'] = 'Limite de intentos alcanzado, tu cuenta ha sido bloqueda temporalmente';
                        $_SESSION['session']=0;
                        $personal->bloqueoIntentos($_POST['usuario']);
                    }elseif($personal->getFechaIntentos()>=1 or $personal->getFechaIntentos()==null ){
                        if ($personal->checkPassword($_POST['clave'])) {
                    if ( $personal->getDiasClave()>90) {
                        $_SESSION['id_personal'] = $personal->getId();
                        $_SESSION['usuario'] = $personal->getUsuario();
                        $result['exception'] = 'Tiene que cambiar su contraseña de inmdediato';
                        $result['noventa'] = 1;
                    }else{
                    $_SESSION['nombre'] = $personal->getNombre();
                    $_SESSION['correo'] = $personal->getEmail();
                    $personal->reinicioConteoIntentos($_POST['usuario']);
                    if(sendemail($_SESSION['nombre'],$_SESSION['correo'],'Auntentificacion de inicio de sesion', 'alguien ha intentado entrar a su cuenta,vaya al sitio e inserte el sigiente codigo para confirmar que es usted')){
                    $result['status'] = 1;
                    $result['message'] = 'Correo eviado';
                    $personal->saveToken();
                    $_SESSION['id_personal'] = $personal->getId();
                    $_SESSION['usuario'] = $personal->getUsuario();
                    $_SESSION['id_cargo'] = $personal->getCargo();
                    }else {
                     $result['exception']=$mail->getFileError;
                    }
                    }
                } else {
                    $result['exception'] = 'Usuario o Contraseña incorectos';
                    $personal->intentoFallido($_POST['usuario']);
                    
                }}else{
                    $result['exception'] = 'No puede acceder';  
                }
                break;
                case 'pswdReco':
                    $_POST = $personal->validateForm($_POST);
                    if (!$personal->checkEmail($_POST['correo'])) {
                        $result['exception'] = 'Correo incorrecto';   
                    }else{
                         $_SESSION['nombre'] = $personal->getNombre();
                        sendemail($_SESSION['nombre'],$_POST['correo'],'Recuperar contraseña',  'ha solicitado un cambio de contraseña, regrese a la pagina e inserte el sigiente condigo para continuar');
                        $result['status'] = 1;
                        $result['message'] ='Correo enviado';
                        $personal->saveToken();
                    }
                    break;
                    case 'forgotPassword':
                        $_POST = $personal->validateForm($_POST);
                        if (!$personal->checkToken($_POST['token'])) {
                            $result['exception'] = 'Token incorrecto';
                        }elseif ($_POST['nueva'] != $_POST['confirmar']) {
                            $result['exception'] = 'Claves nuevas diferentes';
                        } elseif (!$personal->setClave($_POST['nueva'])) {
                            $result['exception'] = $personal->getPasswordError();
                        } elseif ($personal->forgetPassword()) {
                            $result['status'] = 1;
                            $result['message'] = 'Contraseña cambiada correctamente';
                            $personal->deleteToken();
                        } else {
                            $result['exception'] = Database::getException();
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
