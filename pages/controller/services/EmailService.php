<?php
require __DIR__ . '/../../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService {
    private $from;
    private $password;

    public function __construct() {
        $this->from = "info@jemoworkers.com"; // Cambia por tu dirección de correo
        $this->password = "/8Tm5$>dT]"; // ⚠️ Reemplaza por la contraseña del correo
    }

    public function enviarCorreo($destinatarios, $asunto, $mensaje) {
        if (empty($destinatarios) || empty($asunto) || empty($mensaje)) {
            return "Error: Faltan datos para enviar el correo.";
        }

        if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            return '❌ Error: PHPMailer no está cargado correctamente.';
        }
        


        $mail = new PHPMailer(true);
        $errores = [];
        $enviados = 0;

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com'; // Servidor SMTP correcto
            $mail->SMTPAuth = true;
            $mail->Username = $this->from;
            $mail->Password = $this->password;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465; // Puerto SMTP (587 para TLS, 465 para SSL)

            // Remitente
            $mail->setFrom($this->from, 'Jemoworkers');

            // Configurar formato HTML
            $mail->isHTML(true);
            $mail->Subject = $asunto;
            $mail->Body = $mensaje;
            $mail->AltBody = strip_tags($mensaje); // Versión en texto plano

            foreach ($destinatarios as $email) {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errores[] = "Correo no válido: $email";
                    continue;
                }

                $mail->addAddress($email);
                $mail->CharSet = 'UTF-8';

                if ($mail->send()) {
                    $enviados++;
                } else {
                    $errores[] = "Problema al enviar a $email: " . $mail->ErrorInfo;
                }

                $mail->clearAddresses(); // Limpia destinatarios para el siguiente
            }

        } catch (Exception $e) {
            return "❌ Error al enviar el correo: " . $mail->ErrorInfo;
        }

        return $enviados > 0 ? "✅ Correos enviados: $enviados" : "❌ Errores: " . implode(", ", $errores);
    }
}
?>
