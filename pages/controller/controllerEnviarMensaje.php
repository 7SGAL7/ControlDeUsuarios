<?php
session_start();

// Verificar que el usuario haya iniciado sesión
if (empty($_SESSION["id"])) {
    header("location: ../login.php");
    exit();
}

// Incluir la conexión a la base de datos y las librerías necesarias
require '../../bd/conection.php';
require 'services/SmsService.php';
require 'services/EmailService.php';

// Verificar si la solicitud es POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tipoMensaje = $_POST["tipoMensaje"];  // "email" o "sms"
    $mensaje = trim($_POST["mensaje"]);
    $empleadosJSON = $_POST["empleadosSeleccionados"];

    // Validar que los campos no estén vacíos
    if (empty($mensaje) || empty($empleadosJSON)) {
        echo json_encode(["status" => "error", "message" => "Faltan datos en el formulario"]);
        exit();
    }

    // Convertir la lista de empleados de JSON a array
    $empleados = json_decode($empleadosJSON, true);
    if (empty($empleados)) {
        echo json_encode(["status" => "error", "message" => "No hay empleados seleccionados"]);
        exit();
    }

    // Contadores de envíos
    $enviados = 0;
    $errores = 0;

    // Recorrer la lista de empleados y enviar mensajes
    $emailService = new EmailService();
    $smsService = new SmsService();
    foreach ($empleados as $empleado) {
        $id = $empleado["id"];

        // Obtener el correo o teléfono desde la BD
        $sql = "SELECT Name, Email, Phone FROM employees WHERE Matricula = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $datos = $resultado->fetch_assoc();
            $nombre = $datos["Name"];
            $email = $datos["Email"];
            $telefono = $datos["Phone"];
            try{
                if ($tipoMensaje === "email" && !empty($email)) {
                    // Enviar correo con PHPMailer
                    if ($emailService->enviarCorreo(array($email), "Notificación para $nombre", $mensaje)) {
                        $enviados++;
                    } else {
                        $errores++;
                    }
                } elseif ($tipoMensaje === "sms" && !empty($telefono)) {
                    // Enviar SMS con Twilio
                    if ($smsService->enviarSms(array($telefono), $mensaje)) {
                        $enviados++;
                    } else {
                        $errores++;
                    }
                } else {
                    $errores++;
                }
            }catch(Exception $e){
                // Respuesta JSON
                echo json_encode([
                    "status" => "error",
                    "message" => "Algo fallo al hacer el envio."
                ]);
                exit();
            }
        } else {
            $errores++;
        }
    }

    // Respuesta JSON
    echo json_encode([
        "status" => "success",
        "message" => "Mensajes enviados: $enviados, Errores: $errores"
    ]);
    exit();
}

// Si alguien intenta acceder sin enviar POST, redirigir
header("location: ../tableemployees.php");
exit();
?>
