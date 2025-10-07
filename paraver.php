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

// Inicializar cURL para enviar el POST a Google
$ch = curl_init($webhookUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $dataToSend);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
$response = curl_exec($ch);
curl_close($ch);

// 4. FINALIZACIÓN
// Ya no se cierra la conexión a MySQL
header("Location: gracias.html");
exit();

// Opcional: Puedes quitar la sección 'else' ya que no hay mysqli_query
?>

// aqui coloco temporalmente mi antiguo script. por si las moscas...
<?php
// como recibo las variables
$nombre = htmlspecialchars($_POST['name']);
$telefono = htmlspecialchars($_POST['telefono']);
$email = htmlspecialchars($_POST['email']);
$mensaje = htmlspecialchars($_POST['mensaje']);

// coneccion con la base de datos 
$servidor = "sdb-83.hosting.stackcp.net";
$usuario = "form_metro-35303934c379";
$contraseña = "dgc96msrtv";
$nombre_base_datos = "form_metro-35303934c379";

$conexion = mysqli_connect($servidor, $usuario, $contraseña, $nombre_base_datos);

if (mysqli_connect_errno()) {
    die("la conexion a la base de datos fallo: " . mysqli_connect_error()); 
}

// creacion y ejecucion de la sentencia SQL SE USA LA FUNCION NOW() PARA CREAR AUTOMATICAMENTE LA FECHA Y LA HORA EN LA SENTENCIA
$sql = "INSERT INTO DATA_FORM (nombre, telefono, email, mensaje, fecha)
        VALUES ('$nombre', '$telefono', '$email', '$mensaje', NOW())";

//EJECUTAMOS LA CONSULTA 
if (mysqli_query($conexion, $sql)) {
// ... [Después de que la inserción en MySQL es exitosa] ...

// 1. URL del Web Hook de Google Apps Script
$webhookUrl = "https://script.google.com/macros/s/AKfycbwgQJWYdinAaiuszgOpa0FC22ivw0ffUVERVxqogWbtVYnfl5WHa0BSYf6NuwUZEf86QQ/exec"; 

// 2. Datos a enviar a Google Sheets.
// Nota: Aquí se usa el array 'post' para enviar a Google.
$dataToSend = array(
    'nombre' => $nombre,
    'email' => $email,
    'telefono' => $telefono,
    'mensaje' => $mensaje
);

// 3. Inicializar cURL
$ch = curl_init($webhookUrl);

// Configurar cURL para enviar los datos por POST
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $dataToSend);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // No mostrar la respuesta de Google

// 4. Ejecutar el envío a Google Sheets
$response = curl_exec($ch);
curl_close($ch);

// 5. Finalizar el script (como lo hacíamos antes)
mysqli_close($conexion);
header("Location: gracias.html");
exit();

// ... [El resto del script de error] ...

} else {
// por si algo fallo
    echo "Error al insertar datos: " . mysqli_error($conexion);    
} 

?>