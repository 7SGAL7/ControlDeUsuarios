<?php
    session_start();
    if(empty($_SESSION["id"])){
        header("location: ../login.php");
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f8d7da; /* Fondo rojo suave */
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .card {
            width: 100%;
            max-width: 400px;
        }
        .btn-back {
            position: absolute;
            top: 20px;
            left: 20px;
        }
    </style>
</head>
<body>
    <!-- Botón de regreso -->
    <a href="tableemployees.php" class="btn btn-danger btn-regresar">← Regresar</a>

    <div class="container">
        <div class="card shadow">
            <div class="card-header bg-danger text-white text-center">
                <h4>Cambiar Contraseña</h4>
            </div>
            <div class="card-body">
                <form id="formCambiarPassword">
                    <div class="mb-3">
                        <label class="form-label">Contraseña Actual</label>
                        <input type="password" class="form-control" name="password_actual" id = "password_actual" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nueva Contraseña</label>
                        <input type="password" class="form-control" name="password_nueva" id = "password_nueva" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirmar Nueva Contraseña</label>
                        <input type="password" class="form-control" name="password_confirmar" id = "password_confirmar" required>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("formCambiarPassword").addEventListener("submit", function(event) {
            event.preventDefault();

            const password_actual = document.getElementById("password_actual").value;
            const password_nueva = document.getElementById("password_nueva").value;
            const password_confirmar = document.getElementById("password_confirmar").value;

            fetch("controller/controllerCambiarPassword.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    password_actual,
                    password_nueva,
                    password_confirmar
                })
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    icon: data.status === "success" ? "success" : "error",
                    title: data.message
                });

                if (data.status === "success") {
                    document.getElementById("formCambiarPassword").reset();
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Hubo un problema con la solicitud."
                });
            });
        });
    </script>
</body>

</html>
