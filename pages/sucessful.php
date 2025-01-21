<?php
session_start();
    if(empty($_SESSION["matriz"])){
       header("location: register.php");
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Exitoso</title>
    <link rel="stylesheet" href="css/successful.css">
    <link rel="icon" type="image/png" href="icon/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="icon/favicon//favicon.svg" />
    <link rel="shortcut icon" href="icon/favicon//favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="icon/favicon//apple-touch-icon.png" />
    <link rel="manifest" href="icon/favicon//site.webmanifest" />
</head>
<body>
    <div class="success-container container text-center">
            <div class = "col-4">
                <img src="img/employee.svg" alt="Employee" style = "width: 100px">
            </div>
            <div class = "col-4">
                <h1>¡Registro Exitoso!</h1>
                <p>Te has registrado correctamente.</p>
                <p><strong>Número de Trabajador:</strong> <span id="usuario">
                <?php
                    echo $_SESSION['matriz'];
                ?>
                </span></p>
                <p>Por favor <span class = "importante">apúntelo en un lugar seguro</span> ya que es su NÚMERO DE TRABAJADOR y con éste número firmará las hojas de tiempo.</p>
            </div>
    </div>
    <script src="json/sucessful.js"></script>
</body>
</html>
