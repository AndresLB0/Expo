<?php

include('../library/phpmailer651/src/PHPMailer.php');
include('../library/phpmailer651/src/SMTP.php');
include('../library/phpmailer651/src/Exception.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

    require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../modelos/personal.php');
require_once('usuarios.php');
 function sendemail($nombre,$correo,$asunto,$mensaje){
    if (isset($correo)) {
$personal=new Personal;
    if ($personal->setEmail($correo)) {



//Create an instance; passing `true` enables exceptions

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'andres.lborja@hotmail.com';                     //SMTP username
    $mail->Password   = 'gosdytl8';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;            
                         //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                         function generarCodigo($longitud) { 
                            $key = '';
                            $pattern = '1234567890';
                            $max = strlen($pattern)-1;
                    
                            for($i=0;$i < $longitud;$i++) $key .= $pattern[mt_rand(0,$max)];
                            return $key;
                            }
                    
                          //Ejemplo de uso
    $emailTo=$personal->getEmail($correo);
    $mail->setFrom('andres.lborja@hotmail.com', 'S.G.V.M');
    $mail->addAddress($emailTo);     //Add a recipient
    $_SESSION['codigo']=generarCodigo(5);
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject =utf8_decode($asunto);
    $mail->Body    ='<h3>'.$nombre.', Le informamos que '.$mensaje.'</h3>'.'<h1>'.$_SESSION['codigo'].'</h1>';
    

    //generador de cogigos
 
    //Content
    

    $mail->send();
     'El correo se ha enviado';
     return true;
} catch (Exception $e) {
     "El mensage no se pudo enviar,error: {$mail->ErrorInfo}";
     return false;
}

}
}
 }

?>