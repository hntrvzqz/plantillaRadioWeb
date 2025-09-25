
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

$conexion = mysql_connect($servidor, $usuario, $contraseña, $nombre_base_datos);

if (mysql_connect_errno()) {
    die("la conexion a la base de datos fallo: " . mysqliconnect_error()); 
}

// creacion y ejecucion de la sentencia SQL SE USA LA FUNCION NOW() PARA CREAR AUTOMATICAMENTE LA FECHA Y LA HORA EN LA SENTENCIA
$sql = "INSERT INTO DATA_FORM (nombre, telefono, email, mensaje, fecha)
        VALUES ('$nombre', '$telefono', '$email', '$mensaje', NOW())";

//EJECUTAMOS LA CONSULTA 
if (mysqli_query($conexion, $sql)) {
// si fue exitosa 
// luego se cierra la conexion
    mysqli_close($conexion);    
} else {
// por si algo fallo
    echo "Error al insertar datos: " . mysqli_error($conexion);    
} 

?>


