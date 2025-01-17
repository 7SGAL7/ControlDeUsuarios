<?php
require '../../bd/conection.php';

// Verificar si se han recibido los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar los datos del formulario
    $nombre = $conn->real_escape_string($_POST['name']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $city = $conn->real_escape_string($_POST['city']);
    $correo = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $matriz = date("y") . substr($nombre, 0, 1) . substr($lastname, 0, 1) . "";
    $dateWork = date("Y-m-d");

    // Preparar la consulta SQL para insertar los datos
    $sql = "INSERT INTO employees(Name, LastName, Matricula, Password, Birthdate, Phone, DateHiring, Email,City) VALUES ('$nombre', '$lastname', '$matriz' ,'', '$dob', '$phone', $dateWork ,'$correo', '$city')";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
    //if(true){
        session_start();
        // Guardar el dato en la sesión
        $_SESSION['matriz'] = "prueba";
        header("Location: ../sucessful.php");
        exit();
    } else {
        //echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Cerrar la conexión
$conn->close();
?>