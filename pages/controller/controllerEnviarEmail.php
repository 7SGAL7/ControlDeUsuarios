<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $para = trim($_POST["email"]);  // Dirección del destinatario
    $asunto = trim($_POST["asunto"]);
    $mensaje = trim($_POST["mensaje"]);

    // Validación de correo
    if (filter_var($para, FILTER_VALIDATE_EMAIL)) {
        $cabeceras = "From: tuempresa@correo.com\r\n";
        $cabeceras .= "Reply-To: tuempresa@correo.com\r\n";
        $cabeceras .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail($para, $asunto, $mensaje, $cabeceras)) {
            echo json_encode(["status" => "success", "message" => "Correo enviado con éxito"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al enviar el correo"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Correo inválido"]);
    }
}
?>
