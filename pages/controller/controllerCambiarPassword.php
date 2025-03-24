<?php
session_start();
require "../../bd/conection.php"; // Asegúrate de que este archivo conecta correctamente a la base de datos

header("Content-Type: application/json");
$response = ["status" => "error", "message" => ""];

if (!isset($_SESSION["id"])) {
    $response["message"] = "Debes iniciar sesión.";
    echo json_encode($response);
    exit;
}

$id = $_SESSION["id"];
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data["password_actual"]) || !isset($data["password_nueva"]) || !isset($data["password_confirmar"])) {
    $response["message"] = "Datos incompletos.";
    echo json_encode($response);
    exit;
}

$password_actual = trim($data["password_actual"]);
$password_nueva = trim($data["password_nueva"]);
$password_confirmar = trim($data["password_confirmar"]);

if ($password_nueva !== $password_confirmar) {
    $response["message"] = "Las contraseñas nuevas no coinciden.";
    echo json_encode($response);
    exit;
}

$stmt = $conn->prepare("SELECT Password FROM jemoworkersusers WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($password_hash);
$stmt->fetch();
$stmt->close();

if (!password_verify($password_actual, $password_hash)) {
    $response["message"] = "La contraseña actual es incorrecta.";
    echo json_encode($response);
    exit;
}

$nuevo_hash = password_hash($password_nueva, PASSWORD_DEFAULT);
$stmt = $conn->prepare("UPDATE jemoworkersusers SET password = ? WHERE id = ?");
$stmt->bind_param("si", $nuevo_hash, $id);

if ($stmt->execute()) {
    $response["status"] = "success";
    $response["message"] = "Contraseña actualizada correctamente.";
} else {
    $response["message"] = "Error al actualizar la contraseña.";
}

$stmt->close();
$conn->close();
echo json_encode($response);
?>