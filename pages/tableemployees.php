<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Información</title>
    <link rel="stylesheet" href="css/employees.css">
</head>
<body>

<?php
    // Incluir el archivo de conexión
    require '../bd/conection.php';

    $sql = "SELECT * FROM employees";
    $result = $conn->query($sql);

?>

    <div class="container">
        <h1>Información de Contacto</h1>
        <table>
            <thead>
                <tr>
                    <th>Matricula</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Fecha de Inicio</th>
                    <th>Detalles</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['Matricula']; ?></td>
                    <td><?php echo $row['Name']; ?></td>
                    <td><?php echo $row['LastName']; ?></td>
                    <td><?php echo $row['Phone']; ?></td>
                    <td><?php echo $row['Email']; ?></td>
                    <td><?php echo $row['DateHiring']; ?></td>
                    <td><button onclick="verDetalles( '<?php echo $row['Name'] . ' ' . $row['LastName'];?>', '<?php echo $row['Phone']; ?>', '<?php echo $row['Birthdate']; ?>', '<?php echo $row['Email']; ?>', '<?php echo $row['City']; ?>')">Ver Detalles</button></td>
                </tr>
                <?php  } } ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para mostrar detalles -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal()">&times;</span>
            <h2>Detalles del Usuario</h2>
            <p><strong>Nombre:</strong> <span id="detalleNombre"></span></p>
            <p><strong>Teléfono:</strong> <span id="detalleTelefono"></span></p>
            <p><strong>Fecha de Nacimiento:</strong> <span id="detalleFecha"></span></p>
            <p><strong>Correo:</strong> <span id="detalleCorreo"></span></p>
            <p><strong>Ciudad:</strong> <span id="detalleCiudad"></span></p>
        </div>
    </div>
    <?php $conn->close();  ?>
    <script src="json/employees.js">

    </script>
</body>
</html>
