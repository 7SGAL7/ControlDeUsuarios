<?php
require '../bd/conection.php'; // Conexión a la BD

// Obtener los proyectos desde la BD
$sql = "SELECT DISTINCT Proyect FROM employees WHERE Proyect IS NOT NULL AND Proyect != '';";
$result = $conn->query($sql);
$proyectos = [];
while ($row = $result->fetch_assoc()) {
    $proyectos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Mensajes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-color: #f8d7da; /* Fondo rojo suave */
        }
        
        /* Botón de regresar en la esquina superior izquierda */
        .btn-regresar {
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1000;
            font-size: 18px;
            padding: 8px 15px;
            border-radius: 8px;
            text-decoration: none;
        }

        /* Centrar contenido */
        .form-container {
            max-width: 500px;
            margin: auto;
            margin-top: 60px;
        }

        /* Estilos en rojo */
        .card {
            border: 2px solid #d9534f;
            background-color: #ffe5e5;
            border-radius: 10px;
        }

        .card-header {
            background-color: #d9534f;
            color: white;
            text-align: center;
            font-size: 1.5rem;
        }

        .btn-primary {
            background-color: #d9534f;
            border-color: #d9534f;
        }

        .btn-primary:hover {
            background-color: #b52b27;
            border-color: #b52b27;
        }

        .btn-success {
            background-color: #5cb85c;
            border-color: #5cb85c;
        }

        .btn-success:hover {
            background-color: #4cae4c;
            border-color: #4cae4c;
        }
    </style>
</head>
<body>

    <!-- Botón de Regresar -->
    <a href="tableemployees.php" class="btn btn-danger btn-regresar">← Regresar</a>

    <div class="container">
        <div class="form-container">
            <div class="card">
                <div class="card-header">
                    Enviar Correos y Mensajes
                </div>
                <div class="card-body">
                    <!-- Selección de Proyecto -->
                    <div class="mb-3">
                        <label for="proyecto" class="form-label">Seleccionar Proyecto:</label>
                        <select class="form-select" id="proyecto">
                            <option value="">Seleccione un proyecto</option>
                            <?php foreach ($proyectos as $proyecto): ?>
                                <option value="<?= $proyecto['Proyect']; ?>"><?= $proyecto['Proyect']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Lista de Clientes -->
                    <div class="mb-3">
                        <label class="form-label">Clientes:</label>
                        <div id="clientes-lista">
                            <!-- Aquí se cargarán dinámicamente los clientes -->
                        </div>
                    </div>

                    <!-- Campo de Mensaje -->
                    <div class="mb-3">
                        <label for="mensaje" class="form-label">Mensaje:</label>
                        <textarea class="form-control" id="mensaje" rows="4" placeholder="Escribe tu mensaje..."></textarea>
                    </div>

                    <!-- Botones de Envío -->
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-primary w-50 me-2" id="enviarCorreo">Enviar Correo</button>
                        <button class="btn btn-success w-50" id="enviarSMS">Enviar SMS</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Cargar clientes cuando se seleccione un proyecto
            $("#proyecto").change(function () {
                let proyectoId = $(this).val();
                let clientesLista = $("#clientes-lista");
                clientesLista.empty();

                if (proyectoId) {
                    $.get("controller/controllerObtenerCliente.php", { proyecto_id: proyectoId }, function (data) {
                        let clientes = JSON.parse(data);
                        if (clientes.length > 0) {
                            clientes.forEach(cliente => {
                                clientesLista.append(`
                                    <div class="form-check">
                                        <input class="form-check-input cliente-checkbox" type="checkbox" value="${cliente.Email}" data-telefono="${cliente.Phone}">
                                        <label class="form-check-label">${cliente.Name} (${cliente.Email})</label>
                                    </div>
                                `);
                            });
                        } else {
                            clientesLista.append('<p class="text-danger">No hay clientes en este proyecto.</p>');
                        }
                    }).fail(function () {
                        Swal.fire("Error", "No se pudieron cargar los clientes.", "error");
                    });
                }
            });

            // Función para obtener clientes seleccionados
            function obtenerSeleccionados() {
                let seleccionados = [];
                $(".cliente-checkbox:checked").each(function () {
                    seleccionados.push({
                        email: $(this).val(),
                        telefono: $(this).data("telefono")
                    });
                });
                return seleccionados;
            }

            // Enviar Correo con SweetAlert2
            $("#enviarCorreo").click(function () {
                let clientes = obtenerSeleccionados();
                let mensaje = $("#mensaje").val();

                if (clientes.length === 0 || mensaje.trim() === "") {
                    Swal.fire("Error", "Selecciona clientes y escribe un mensaje.", "error");
                    return;
                }

                $.post("controllerEnviarEmail.php", { clientes: clientes, mensaje: mensaje }, function (respuesta) {
                    Swal.fire("Éxito", respuesta, "success");
                }).fail(function () {
                    Swal.fire("Error", "Hubo un problema al enviar el correo.", "error");
                });
            });

            // Enviar SMS con SweetAlert2
            $("#enviarSMS").click(function () {
                let clientes = obtenerSeleccionados();
                let mensaje = $("#mensaje").val();

                if (clientes.length === 0 || mensaje.trim() === "") {
                    Swal.fire("Error", "Selecciona clientes y escribe un mensaje.", "error");
                    return;
                }

                $.post("controllerEnviarSMS.php", { clientes: clientes, mensaje: mensaje }, function (respuesta) {
                    Swal.fire("Éxito", respuesta, "success");
                }).fail(function () {
                    Swal.fire("Error", "Hubo un problema al enviar el SMS.", "error");
                });
            });
        });
    </script>

</body>
</html>
