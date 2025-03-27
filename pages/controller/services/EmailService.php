<?php
    class EmailService {
        private $from;

        public function __construct() {
            $this->from = "info@jemoworkers.com"; // Cambia por tu dirección de correo
        }

        public function enviarCorreo($destinatarios, $asunto, $mensaje) {
            if (empty($destinatarios) || empty($asunto) || empty($mensaje)) {
                return "Error: Faltan datos para enviar el correo.";
            }

            // Encabezados del correo
            $headers = "From: " . $this->from . "\r\n";
            $headers .= "Reply-To: " . $this->from . "\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            // Enviar el correo a cada destinatario
            foreach ($destinatarios as $email) {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return "Error: Dirección de correo no válida ($email).";
                }
                try{
                    if (!mail($email, $asunto, $mensaje, $headers)) {
                        return "Error al enviar el correo a $email.";
                    }
                }catch (Exception $e){
                    return "Error al enviar el correo a $email.";
                }
            }

            return "Correo enviado con éxito.";
        }
    }
?>
