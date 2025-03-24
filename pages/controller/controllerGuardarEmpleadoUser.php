<?php
header("Content-Type: application/json"); // Asegurar que la respuesta sea JSON
session_start();
require_once "../../bd/conection.php"; // Conexión a la BD

// Verificar si hay sesión activa
if (empty($_SESSION["idtrabajador"])) {
    echo json_encode(["status" => "error", "message" => "Debes iniciar sesión primero."]);
    exit();
}

$id = $_SESSION["idtrabajador"];

// Recibir datos del formulario
$nombre = $_POST["detalleNombre"] ?? null;
$apellido = $_POST["detalleApellido"] ?? null;
$correo = $_POST["detalleCorreo"] ?? null;
$direccion = $_POST["detalledireccion"] ?? null;
$fecha_nacimiento = $_POST["detalleFecha"] ?? null;
$ssn = $_POST["detalleSSN"] ?? null;
$ruta = null; // Inicializar variable de imagen

// Manejo de imagen si se subió
if (isset($_FILES['detalleImagen']) && $_FILES['detalleImagen']['error'] == 0) {
    $imagen_nombre = basename($_FILES['detalleImagen']['name']);
    $ruta = "../../imgTrabajadores/" . $imagen_nombre;

    // Crear directorio si no existe
    if (!file_exists("../../imgTrabajadores/")) {
        mkdir("../../imgTrabajadores/", 0777, true);
    }

    if (move_uploaded_file($_FILES['detalleImagen']['tmp_name'], $ruta)) {
        // Imagen movida correctamente, se actualizará en la BD
    } else {
        echo json_encode(["status" => "error", "message" => "Error al mover la imagen."]);
        exit();
    }
}

// Construcción de la consulta SQL dinámica
$sql = "UPDATE employees SET Name = ?, LastName = ?, Email = ?, Address = ?, Birthdate = ?, SSN = ?";
$param_types = "ssssss";
$params = [$nombre, $apellido, $correo, $direccion, $fecha_nacimiento, $ssn];

if ($ruta) { // Si hay imagen, incluirla en la consulta
    $sql .= ", foto = ?";
    $param_types .= "s";
    $params[] = $ruta;
}

$sql .= " WHERE id = ?";
$param_types .= "i";
$params[] = $id;

// Preparar y ejecutar la consulta
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "Error en la consulta SQL."]);
    exit();
}

// Pasar parámetros dinámicamente
$stmt->bind_param($param_types, ...$params);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Datos actualizados correctamente."]);
} else {
    echo json_encode(["status" => "error", "message" => "No se pudo actualizar la BD.", "sql_error" => $stmt->error]);
}
exit();
?>
