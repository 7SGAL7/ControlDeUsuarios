<?php
session_start();

$tiempo_bloqueo = 10 * 60; // 10 minutos en segundos

// Calcular tiempo restante si está bloqueado
if (isset($_SESSION['bloqueo'])) {
    $tiempo_restante = ($_SESSION['bloqueo'] + $tiempo_bloqueo) - time();
    
    if ($tiempo_restante > 0) {
        // Mostrar la pantalla de bloqueo
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Acceso Bloqueado</title>
            <link rel="icon" type="image/png" href="icon/favicon/favicon-96x96.png" sizes="96x96" />
            <link rel="icon" type="image/svg+xml" href="icon/favicon//favicon.svg" />
            <link rel="shortcut icon" href="icon/favicon//favicon.ico" />
            <link rel="apple-touch-icon" sizes="180x180" href="icon/favicon//apple-touch-icon.png" />
            <link rel="manifest" href="icon/favicon//site.webmanifest" />
            <style>
                body {
                    font-family: Arial, sans-serif;
                    text-align: center;
                    background-color: #f8d7da;
                    color: #721c24;
                    padding: 50px;
                }
                .container {
                    background: white;
                    padding: 20px;
                    border-radius: 10px;
                    display: inline-block;
                    box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
                }
                h1 {
                    color: #dc3545;
                }
                .timer {
                    font-size: 24px;
                    font-weight: bold;
                }
                .reload {
                    margin-top: 20px;
                    display: inline-block;
                    background: #dc3545;
                    color: white;
                    padding: 10px 20px;
                    text-decoration: none;
                    border-radius: 5px;
                }
                .reload:hover {
                    background: #c82333;
                }
            </style>
            <meta http-equiv="refresh" content="60"> <!-- Refresca la página cada 60 segundos -->
        </head>
        <body>
            <div class="container">
                <h1>⚠ Acceso Bloqueado</h1>
                <p>Has superado el número de intentos permitidos.</p>
                <p>Intenta de nuevo en:</p>
                <p class="timer"><?= ceil($tiempo_restante / 60); ?> minutos</p>
                <a href="bloqueo.php" class="reload">Actualizar</a>
            </div>
        </body>
        </html>
        <?php
        exit; // Detiene la ejecución
    } else {
        // Si ya pasaron los 10 minutos, eliminar el bloqueo
        unset($_SESSION['bloqueo']);
        $_SESSION['intentos'] = 0;
        header("location: ../login.php");
    }
}
?>
