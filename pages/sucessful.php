<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Exitoso</title>
    <link rel="stylesheet" href="css/successful.css">
    <link rel="icon" href="img/JEMO-ICON.png">
</head>
<body>
    <div class="success-container">
        <h1>¡Registro Exitoso!</h1>
        <p>Te has registrado correctamente.</p>
        <p><strong>Número de Trabajador:</strong> <span id="usuario">
        <?php
        session_start();
            echo $_SESSION['matriz'];
        ?>
        </span></p>
        <p>Por favor <span class = "importante">apúntelo en un lugar seguro</span> ya que es su NÚMERO DE TRABAJADOR y con éste número firmará las hojas de tiempo.</p>
    </div>

    <script src="json/sucessful.js"></script>
</body>
</html>
