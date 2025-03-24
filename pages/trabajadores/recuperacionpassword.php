<?php
require '../../bd/conection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Verificar si el correo existe en la base de datos
        $stmt = $conn->prepare("SELECT * FROM employees WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Cerrar la consulta anterior
        $stmt->close();

        if ($user) {
            // Generar un token único
            $token = bin2hex(random_bytes(50));

            // Insertar el token en la tabla password_resets
            $stmt = $conn->prepare("INSERT INTO password_resets (email, token) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $token);
            $stmt->execute();
            $stmt->close(); // Cerrar la consulta después de ejecutarla

            // Enviar correo con el enlace de recuperación
            $resetLink = "http://localhost/Registrodeusuario/pages/restablecer.php?token=$token";
            $to = $email;
            $subject = "Recuperación de Contraseña";
            $message = "Haz clic en el siguiente enlace para restablecer tu contraseña: <a href='$resetLink'>$resetLink</a>";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: info@jemoworkers.com";

            if (mail($to, $subject, $message, $headers)) {
                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Correo enviado',
                        text: 'Revisa tu bandeja de entrada para restablecer tu contraseña.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                </script>";
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al enviar el correo.',
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


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
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

</body>
</html>