<?php
require '../../bd/conection.php';

// Verificar si se han recibido los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar los datos del formulario
    
    
    $sql_id = "SELECT id FROM employees ORDER BY id DESC LIMIT 1;";
    $result = $conn->query($sql_id);

    if ($result->num_rows > 0) { 
        $row = $result->fetch_assoc();
        $id = $row['id'] + 1;
    }else{
        $id = 1;
    }

    $nombre = strtoupper($conn->real_escape_string($_POST['name']));
    $lastname = strtoupper($conn->real_escape_string($_POST['lastname']));
    $dob = $conn->real_escape_string($_POST['dob']);
    $city = strtoupper($conn->real_escape_string($_POST['city']));
    $correo = strtoupper($conn->real_escape_string($_POST['email']));
    $phone = $conn->real_escape_string($_POST['phone']);
    $matriz = substr($nombre, 0, 1) . substr($lastname, 0, 1) .  str_pad($id, 3, "0", STR_PAD_LEFT);;
    $dateWork = date("Y-m-d");

    // Preparar la consulta SQL para insertar los datos
    $sql = "INSERT INTO employees(Name, LastName, Matricula, Password, Birthdate, Phone, DateHiring, Email,City) VALUES ('$nombre', '$lastname', '$matriz' ,'', '$dob', '$phone', '$dateWork' ,'$correo', '$city')";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        session_start();
        // Guardar el dato en la sesión
        $_SESSION['matriz'] = $matriz;
        header("Location: ../sucessful.php");
        exit();
    }
    
}

$conn->close();
?>