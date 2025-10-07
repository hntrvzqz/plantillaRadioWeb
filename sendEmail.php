<?php
// Reporte de errores (Mantenemos esto para depuración)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. RECEPCIÓN Y SANITIZACIÓN DE DATOS
$nombre = htmlspecialchars($_POST['name']);
$telefono = htmlspecialchars($_POST['telefono']);
$email = htmlspecialchars($_POST['email']);
$mensaje = htmlspecialchars($_POST['mensaje']);

// ----------------------------------------------------------------------
// 2. SOLUCIÓN TEMPORAL: Guardar en archivo para saltar el error de mysqli
// ----------------------------------------------------------------------

// Formato de la línea de texto a guardar
$log_data = date("Y-m-d H:i:s") . " | Nombre: $nombre | Email: $email | Tel: $telefono | Mensaje: $mensaje\n";

// Escribe la información en un archivo de texto llamado 'registros_fallidos.txt'
file_put_contents('registros_fallidos.txt', $log_data, FILE_APPEND);

// ----------------------------------------------------------------------
// 3. CONTINUACIÓN: Enviar al Web Hook de Google Sheets
// ----------------------------------------------------------------------

// NO HAY CONEXIÓN A BD, SIMPLEMENTE ASUMIMOS ÉXITO TEMPORALMENTE
// Ya no necesitamos el IF, el script corre linealmente

// URL del Web Hook de Google Apps Script (Tu URL REAL)
$webhookUrl = "https://script.google.com/macros/s/AKfycbwgQJWYdinAaiuszgOpa0FC22ivw0ffUVERVxqogWbtVYnfl5WHa0BSYf6NuwUZEf86QQ/exec"; 

$dataToSend = array(
    'nombre' => $nombre,
    'email' => $email,
    'telefono' => $telefono,
    'mensaje' => $mensaje
);

$postData = http_build_query($dataToSend);

// Inicializar cURL para enviar el POST a Google
$ch = curl_init($webhookUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
//$response = 
curl_exec($ch);
curl_close($ch);

// 4. FINALIZACIÓN
// Ya no se cierra la conexión a MySQL
header("Location: gracias.html");
exit();

// Opcional: Puedes quitar la sección 'else' ya que no hay mysqli_query
?>

