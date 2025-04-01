<?php
    require '../bd/conection.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
    <link rel="icon" type="image/png" href="icon/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="icon/favicon//favicon.svg" />
    <link rel="shortcut icon" href="icon/favicon//favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="icon/favicon//apple-touch-icon.png" />
    <link rel="manifest" href="icon/favicon//site.webmanifest" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f8d7da; /* Rojo claro */
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            text-align: center;
        }
        .btn-danger {
            background-color: #d9534f;
            border: none;
        }
        .btn-danger:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="container">
        <h2 class="mb-3 text-danger">Restablecer Contraseña</h2>
        <form method="POST" onsubmit="return validarContrasena();">
            <div class="mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Nueva contraseña" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirmar contraseña" required>
            </div>
            <button type="submit" class="btn btn-danger w-100">Actualizar Contraseña</button>
        </form>
    </div>

    <script>
        function validarContrasena() {
            let password = document.getElementById("password").value;
            let confirmPassword = document.getElementById("confirm_password").value;

            if (password !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Las contraseñas no coinciden. Inténtalo de nuevo.',
                    confirmButtonColor: '#d33'
                });
                return false; // Evita que se envíe el formulario
            }
            return true; // Permite enviar el formulario
        }
    </script>

    <?php
        if (isset($_GET['token'])) {
            $token = $_GET['token'];

            // Verificar si el token es válido y no ha expirado
            $stmt = $conn->prepare("SELECT email FROM password_resets WHERE token = ? AND created_at >= NOW() - INTERVAL 1 HOUR");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if (!$row) {
                header("location: ErrorToken.php");
                exit;
            }

            $email = $row['email'];

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $password = $_POST["password"];
                $confirm_password = $_POST["confirm_password"];

                // Verificar que las contraseñas coincidan
                if ($password !== $confirm_password) {
                    echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Las contraseñas no coinciden. Inténtalo de nuevo.',
                            confirmButtonColor: '#d33'
                        });
                    </script>";
                } else {

                    
                    echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Contraseña actualizada',
                        text: 'Ahora puedes iniciar sesión con tu nueva contraseña.',
                        confirmButtonColor: '#3085d6'
                    });
                    </script>";
                    
                    sleep(5);
                    
                    // Encriptar la nueva contraseña
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Actualizar la contraseña en la base de datos
                    $stmt = $conn->prepare("UPDATE employees SET password = ? WHERE email = ?");
                    $stmt->bind_param("ss", $hashed_password, $email);
                    $stmt->execute();

                    // Eliminar el token después de usarlo
                    $stmt = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
                    $stmt->bind_param("s", $email);
                    $stmt->execute();

                    header("location: ../login.php");
                    exit;
                }
            }
        } else {
            header("location: ErrorToken.php");
        }

    ?>
</body>
</html>
