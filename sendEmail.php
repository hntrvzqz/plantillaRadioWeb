<?php
// aqui se Cargan las clases de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


// las rutas a los archivos
require 'phpMailer/Exception.php';
require 'phpMailer/PHPMailer.php';
require 'phpMailer/SMTP.php';


$mail = new PHPMailer(true); 
?>


$correo_del_cliente = $_POST['email'];
$mensaje_del_cliente = $_POST['mensaje'];