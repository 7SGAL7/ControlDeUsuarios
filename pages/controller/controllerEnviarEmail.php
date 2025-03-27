<?php

    require 'services/EmailService.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        $clientes = $_POST["clientes"] ?? [];
        $mensaje = trim($_POST["mensaje"]);

        if (empty($clientes) || empty($mensaje)) {
            echo "Error: Selecciona clientes y escribe un mensaje.";
            exit;
        }

        $emails = array_column($clientes, 'email');
        $emailService = new EmailService();
        $respuesta = $emailService->enviarCorreo($emails, "Notificación de Proyecto", $mensaje);

        echo $respuesta;

    }
?>
