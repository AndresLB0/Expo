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
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como clientes para realizar las acciones correspondientes.
    if (isset($_SESSION['id_personal'])) {
        // Se compara la acción a realizar cuando un clientes ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAllInsti':
                if ($result['dataset'] = $clientes->readAllInsti()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                case 'readAllMedi':
                    if ($result['dataset'] = $clientes->readAllMedi()) {
                        $result['status'] = 1;
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay datos registrados';
                    }
                    break;
                    case 'createMedi':
                        $_POST = $clientes->validateForm($_POST);
                        if (!$clientes->setNombreCl($_POST['nombre_cliente'])) {
                            $result['exception'] = 'Nombre incorrecto';
                        } elseif (!$clientes->setAutodnm($_POST['DNM'])) {
                            $result['exception'] = 'Aurizacion DNM incorrecta';
                        }elseif (!$clientes->setNac($_POST['cumple'])) {
                            $result['exception'] = 'Fecha incorrecta';
                        }elseif (!$clientes->setCont($_POST['N'])) {
                            $result['exception'] = 'Nombre de contacto incorrecto';
                        }elseif (!$clientes->setHorario($_POST['horario'])) { 
                            $result['exception'] = 'Horario incorrecto';
                        }elseif (!$clientes->setDireccion($_POST['direccion'])) {
                            $result['exception'] = 'Direccion incorrecta';
                        }elseif (!$clientes->setDui($_POST['DN'])) {
                            $result['exception'] = 'DUI incorrecto';
                        }elseif (!$clientes->setNrc($_POST['NRC'])) {
                            $result['exception'] = 'NRC incorrecto';
                        }elseif (!$clientes->setMontMaxVent($_POST['monto'])) {
                            $result['exception'] = 'Monto Maximo de ventas incorrecto';
                        }elseif (!$clientes->setDescuento($_POST['desc'])) {
                            $result['exception'] = 'Descuento incorrecto';
                        }elseif (!$clientes->setNumerojunta($_POST['Ndj']) and !null) {
                            $result['exception'] = 'Numero de junta incorrecto';
                        }elseif (!$clientes->setEspeci($_POST['especi'])) {
                            $result['exception'] = 'Especialidad incorrecta';
                        }elseif ($clientes->createRowMedi()) {
                            $result['status'] = 1;
                                $result['message'] = 'Cliente creado correctamente';
                        } else {
                            $result['exception'] = Database::getException();
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
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
