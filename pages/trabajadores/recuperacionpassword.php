<?php
require '../../bd/conection.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link rel="icon" type="image/png" href="../icon/favicon/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/svg+xml" href="../icon/favicon/favicon.svg">
    <link rel="shortcut icon" href="../icon/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="../icon/favicon/apple-touch-icon.png">
    <link rel="manifest" href="../icon/favicon/site.webmanifest">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f8d7da; /* Fondo rojo claro */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            border: 2px solid #dc3545; /* Borde rojo */
            box-shadow: 0 0 15px rgba(220, 53, 69, 0.3); /* Sombra roja */
            max-width: 400px;
            text-align: center;
        }
        .btn-danger {
            background-color: #dc3545; /* Rojo fuerte */
            border: none;
        }
        .btn-danger:hover {
            background-color: #c82333; /* Rojo más oscuro al pasar el mouse */
        }
        input.form-control {
            border: 2px solid #dc3545; /* Borde rojo en el input */
        }
        input.form-control:focus {
            border-color: #c82333;
            box-shadow: 0 0 5px rgba(220, 53, 69, 0.5);
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="mb-3 text-danger">Recuperar Contraseña</h2>
    <p>Ingresa tu correo para restablecer tu contraseña.</p>
    <form method="POST">
        <div class="mb-3">
            <input type="email" class="form-control" name="email" placeholder="Correo electrónico" required>
        </div>
        <button type="submit" class="btn btn-danger w-100">Enviar</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
    require '../../bd/conection.php'; 
    require '../../vendor/autoload.php'; // Asegúrate de que esta ruta sea correcta

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Verificar si el correo existe en la base de datos
            $stmt = $conn->prepare("SELECT * FROM employees WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();

            if ($user) {
                // Generar un token único
                $token = bin2hex(random_bytes(50));

                // Insertar el token en la base de datos
                $stmt = $conn->prepare("INSERT INTO password_resets (email, token) VALUES (?, ?)");
                $stmt->bind_param("ss", $email, $token);
                $stmt->execute();
                $stmt->close();

                // Enlace de recuperación
                $resetLink = "http://localhost/Registrodeusuario/pages/RestablecerPasswordTrabajador.php?token=$token";

                // Configuración de PHPMailer
                $mail = new PHPMailer(true);
                try {
                    // Configuración del servidor SMTP
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.hostinger.com'; // Cambia esto por tu servidor SMTP
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'info@jemoworkers.com'; // Cambia esto por tu correo
                    $mail->Password   = '/8Tm5$>dT]'; // Cambia esto por tu contraseña
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port       = 465; // Puerto SMTP

                    // Configuración del correo
                    $mail->setFrom('info@jemoworkers.com', 'Soporte - Jemoworkers');
                    $mail->addAddress($email); // Destinatario
                    // Asegurar que el correo use UTF-8
                    $mail->CharSet = 'UTF-8';

                    // Configurar el asunto del correo
                    $mail->Subject = '🔑 Recuperación de Contraseña';

                    // Diseño del cuerpo del correo
                    $mail->Body = '
                    <!DOCTYPE html>
                    <html lang="es">
                    <head>
                        <meta charset="UTF-8">
                        <title>Recuperación de Contraseña</title>
                    </head>
                    <body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; text-align: center;">
                        <div style="max-width: 500px; background: white; padding: 20px; margin: auto; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                            <h2 style="color: #333;">Solicitud de Recuperación de Contraseña</h2>
                            <p style="color: #666;">Hola, hemos recibido una solicitud para restablecer tu contraseña.</p>
                            <p style="color: #666;">Si no realizaste esta solicitud, ignora este mensaje.</p>
                            <a href="'.$resetLink.'" style="display: inline-block; padding: 10px 20px; color: white; background-color: #dc3545; text-decoration: none; border-radius: 5px; font-weight: bold;">
                                Restablecer Contraseña
                            </a>
                            <p style="color: #999; font-size: 12px; margin-top: 20px;">
                                Si el botón no funciona, copia y pega el siguiente enlace en tu navegador:<br>
                                <a href="'.$resetLink.'" style="color: #dc3545;">'.$resetLink.'</a>
                            </p>
                            <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">
                            <p style="color: #aaa; font-size: 12px;">© '.date("Y").' Jemoworkers. Todos los derechos reservados.</p>
                        </div>
                    </body>
                    </html>';

                    // Habilitar contenido HTML en el correo
                    $mail->isHTML(true);
                    // Enviar el correo
                    $mail->send();

                    echo "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Correo enviado',
                            text: 'Revisa tu bandeja de entrada para restablecer tu contraseña.',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                    </script>";

                } catch (Exception $e) {
                    echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un problema al enviar el correo: {$mail->ErrorInfo}',
                            confirmButtonColor: '#d33'
                        });
                    </script>";
                }
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Correo no encontrado',
                        text: 'Este correo no está registrado en nuestra base de datos.',
                        confirmButtonColor: '#d33'
                    });
                </script>";
            }
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Correo inválido',
                    text: 'Por favor, ingresa un correo válido.',
                    confirmButtonColor: '#d33'
                });
            </script>";
        }

        // Cerrar la conexión
        $conn->close();
    }
?>

</body>
</html>