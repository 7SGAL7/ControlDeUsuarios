<?php

    session_start();
    if(empty($_SESSION["id"])){
        header("location: ../../login.php");
    }

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../../bd/conection.php';
    // Obtener los datos del formulario
    $id = $_POST['detalleID'];
    $nombre = $_POST['detalleNombre'];
    $apellido = $_POST['detalleApellido'];
    $correo = $_POST['detalleCorreo'];
    $direccion = $_POST['detalledireccion'];
    $ciudad = $_POST['detalleCiudad'];
    $telefono = $_POST['detalleTelefono'];
    $fecha_nacimiento = $_POST['detalleFecha'];
    $fecha_ingreso = $_POST['detailDateHiring'];
    $firmo_contrato = $_POST['detailSign'];
    $hospedaje = $_POST['detailhospedaje'];
    $proyecto = $_POST['detalleProyecto'];
    $tipo = $_POST['detalleTipo'];
    $clasificacion = $_POST['detalleClasificacion'];
    $ssn = $_POST['detalleSSN'];
    $deposito_directo = $_POST['detaildeposito'];
    $payRate = $_POST['detallePayRate'];
    $active = $_POST['detailactivo'];
    $comentario = str_replace(array("\r", "\n"), ' ', $_POST['DetailComment']);

    // Preparar la consulta SQL para insertar los datos
    $sql = "UPDATE employees 
    SET Name = '$nombre', LastName = '$apellido', Email = '$correo', Address = '$direccion', 
        City = '$ciudad', Phone = '$telefono', Birthdate = '$fecha_nacimiento', 
        DateHiring = '$fecha_ingreso', SIGN = '$firmo_contrato', 
        lodging = '$hospedaje', Proyect = '$proyecto', type = '$tipo', 
        classification = '$clasificacion', SSN = '$ssn', DirectDeposit = '$deposito_directo', 
        Comments = '$comentario', PayRate = '$payRate', Active = '$active'
    WHERE id = '$id'";;

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        header("Location: ../tableemployees.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}
?>