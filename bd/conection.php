<?php
// Definir las credenciales de la base de datos
$host = 'localhost'; // O la IP del servidor MySQL
$usuario = 'root';   // Tu nombre de usuario
$contraseña = '';    // Tu contraseña
$base_de_datos = 'jemoworkers'; // El nombre de tu base de datos

// Crear la conexión usando mysqli
$conn = new mysqli($host, $usuario, $contraseña, $base_de_datos);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

?>