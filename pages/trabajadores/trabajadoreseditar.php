<?php
    session_start();
    require_once "../../bd/conection.php"; // Asegura que este archivo conecta correctamente a la BD

    // Verificar si el usuario ha iniciado sesión
    if (empty($_SESSION["idtrabajador"])) {
        header("location: ../../login.php");
        exit();
    }

    $id = $_SESSION["idtrabajador"];

    // Incluir el archivo de conexión
    require 'MenuTrabajadores.php';

    // Consulta para obtener los datos del trabajador
    $sql = "SELECT Name, LastName, Email, Address, Birthdate, SSN, foto FROM employees WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $empleado = $result->fetch_assoc();

    // Verificar si encontró datos
    if (!$empleado) {
        die("Error: No se encontró el trabajador en la base de datos.");
    }

    // Variables con datos del usuario
    $nombre = htmlspecialchars($empleado["Name"]);
    $apellido = htmlspecialchars($empleado["LastName"]);
    $correo = htmlspecialchars($empleado["Email"]);
    $direccion = htmlspecialchars($empleado["Address"]);
    $fecha_nacimiento = $empleado["Birthdate"];
    $ssn = htmlspecialchars($empleado["SSN"]);
    $foto = !empty($empleado["foto"]) ? $empleado["foto"] : "../img/employeeicon.png";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Empleado</title>
    <link rel="icon" type="image/png" href="../icon/favicon/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/svg+xml" href="../icon/favicon/favicon.svg">
    <link rel="shortcut icon" href="/pages/icon/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="../icon/favicon/apple-touch-icon.png">
    <link rel="manifest" href="../icon/favicon/site.webmanifest">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="../librery/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../librery/js/bootstrap.bundle.min.js"></script>
    <script src="../librery/js/jquery-3.7.1.js"></script>
    <style>
        body { background-color: #f8d7da;  padding-top: 30px;}
        .container { min-height: 100vh; display: flex; justify-content: center; align-items: center; padding: 40px 0;}
        .card { max-width: 600px; width: 100%; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); background-color: white; }
        .card-header { background-color: #dc3545; color: white; text-align: center; font-size: 1.5rem; font-weight: bold; padding: 15px; }
        .btn-red { background-color: #dc3545; color: white; border: none; }
        .btn-red:hover { background-color: #b52b3b; }
        .image-preview { width: 100px; height: 100px; border-radius: 50%; border: 2px solid #dc3545; display: flex; align-items: center; justify-content: center; overflow: hidden; margin: auto; background-color: #f8f9fa; }
        .image-preview img { width: 100%; height: auto; }
    </style>
</head>
<body>
<div class="container menu-config">
        <div class="card">
            <div class="card-header">Actualizar Información</div>
            <div class="card-body">
                <form id="formUsuario" action="../controller/controllerGuardarEmpleadoUser.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="detalleID" id="detalleID" value="<?= $id; ?>">

                    <!-- Vista previa de la imagen -->
                    <div class="image-preview mb-3" id="imagePreview">
                        <img src="<?= $foto; ?>" id="previewImg" alt="Vista previa">
                    </div>
                    <!-- Campo para subir imagen -->
                    <div class="mb-3 text-center">
                        <label class="form-label" for="detalleImagen">Subir Imagen:</label>
                        <input class="form-control" type="file" id="detalleImagen" name="detalleImagen" accept="image/*" onchange="previewImage(event)">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="detalleNombre">Nombre(s):</label>
                        <input class="form-control" type="text" id="detalleNombre" name="detalleNombre" value="<?= $nombre; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="detalleApellido">Apellido(s):</label>
                        <input class="form-control" type="text" id="detalleApellido" name="detalleApellido" value="<?= $apellido; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="detalleCorreo">Correo:</label>
                        <input class="form-control" type="email" id="detalleCorreo" name="detalleCorreo" value="<?= $correo; ?>" required>
                    </div>

                    <div class="mb-3 mt-3">
                        <label class="form-label" for="detalledireccion">Dirección:</label>
                        <input class="form-control" type="text" id="detalledireccion" name="detalledireccion" value="<?= $direccion; ?>">
                    </div>
                    <div class="d-flex">
                        <div class="p-2 flex-fill">
                            <label class="form-label" for="detalleFecha">Fecha de Nacimiento:</label>
                            <input class="form-control" type="date" id="detalleFecha" name="detalleFecha" value="<?= $fecha_nacimiento; ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="detalleSSN">SSN</label>
                        <input class="form-control" type="text" id="detalleSSN" name="detalleSSN" value="<?= $ssn; ?>">
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-red w-50">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('previewImg');
            const reader = new FileReader();

            reader.onload = function() {
                preview.src = reader.result;
            };

            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#formUsuario").submit(function (event) {
                event.preventDefault(); // Evitar que la página se recargue

                var formData = new FormData(this); // Capturar datos del formulario

                $.ajax({
                    url: "../controller/controllerGuardarEmpleadoUser.php",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log("Respuesta del servidor:", response); 
                        try {
                            var res = (typeof response === "string") ? JSON.parse(response) : response;  // ✅ CORREGIDO
                            if (res.status === "success") {
                                Swal.fire({
                                    icon: "success",
                                    title: "¡Éxito!",
                                    text: res.message,
                                    confirmButtonColor: "#28a745"
                                }).then(() => {
                                    location.reload(); // Recargar la página
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text: res.message,
                                    confirmButtonColor: "#dc3545"
                                });
                            }
                        } catch (error) {
                            Swal.fire({
                                icon: "error",
                                title: "Error inesperado",
                                text: "No se pudo procesar la respuesta.",
                                confirmButtonColor: "#dc3545"
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "No se pudo conectar con el servidor.",
                            confirmButtonColor: "#dc3545"
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
