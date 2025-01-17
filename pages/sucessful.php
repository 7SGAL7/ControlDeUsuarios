<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Exitoso</title>
    <link rel="stylesheet" href="css/successful.css">
</head>
<body>
    <div class="success-container">
        <h1>¡Registro Exitoso!</h1>
        <p>Te has registrado correctamente.</p>
        <p><strong>Usuario:</strong> <span id="usuario">
        <?php
        session_start();
        echo $_SESSION['matriz'];
        ?>
        </span></p>
        
    </div>

    <script src="json/sucessful.js"></script>
</body>
</html>
