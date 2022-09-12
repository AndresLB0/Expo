<?php

include('../library/phpmailer651/src/PHPMailer.php');
include('../library/phpmailer651/src/SMTP.php');
include('../library/phpmailer651/src/Exception.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
if (isset($_POST['correo'])) {
    require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../modelos/personal.php');
$personal=new Personal;
    if ($personal->setEmail($_POST['correo'])) {



//Create an instance; passing `true` enables exceptions

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp-mail.outlook.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'andres.lborja@hotmail.com';                     //SMTP username
    $mail->Password   = 'gosdytl8';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;            
                         //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //
    $emailTo=$personal->getEmail($_POST['correo']);
    $mail->setFrom('andres.lborja@hotmail.com', 'dinypoladus');
    $mail->addAddress($emailTo);     //Add a recipient
    $mail->addBCC('ojosabiosadesv@gmail.com');

    //generador de cogigos
    function generarCodigo($longitud) { 
        $key = '';
        $pattern = '1234567890';
        $max = strlen($pattern)-1;

        for($i=0;$i < $longitud;$i++) $key .= $pattern[mt_rand(0,$max)];
        return $key;
        }

      //Ejemplo de uso
      $canidad = 50;
      for($c=0; $c<=$canidad; $c++){
      }
    //Content
    $codigo=generarCodigo(5);
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject =utf8_decode('recuperacion de contraseña');
    $mail->Body    = 'usted ha solicitado un cambio de contraseña, para continuar ponga el siguiente codigo <h1>'.$codigo.'</h1>';
    

    $mail->send();
     define('succesfull','El correo se ha enviado');
} catch (Exception $e) {
    $error= "el mensage no se pudo enviar,error: {$mail->ErrorInfo}";
}

}
}
?>