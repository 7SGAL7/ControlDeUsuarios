<?php
require 'services/SmsService.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clientes = $_POST["clientes"] ?? [];
    $mensaje = trim($_POST["mensaje"]);

    if (empty($clientes) || empty($mensaje)) {
        echo json_encode(["status" => "error", "message" => "Cliente o mensaje vacíos."]);
        exit;
    }

    try{
        $telefonos = array_column($clientes, 'telefono');
        $smsService = new SmsService();
        $respuesta = $smsService->enviarSms($telefonos, $mensaje);
        echo $respuesta;
    }catch (Exception $e){
        echo json_encode(["status" => "error", "message" => "Error al enviar."]);
    }

}

?>
