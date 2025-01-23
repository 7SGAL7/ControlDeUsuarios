<?php 
    session_start();
    $errores = [];
    $nombre = $apellido = $fecha_nacimiento = $ciudad = $email = $telefono = '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Registro de Trabajadores</title>
    <link rel="icon" type="image/png" href="icon/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="icon/favicon//favicon.svg" />
    <link rel="shortcut icon" href="icon/favicon//favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="icon/favicon//apple-touch-icon.png" />
    <link rel="manifest" href="icon/favicon//site.webmanifest" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="css/register.css">
    <style>
        
    </style>
</head>
<body>
    <form  method="POST" class="mt-4">
        <div class="mb-3 espaciado-main">
        </div>
        <div class="mb-3" style = "text-align:center">
            <img src="img/JEMO-ICON.svg" alt="Jemo Contractor LLC" class="img-fluid">
            
            <h2>Registro de Trabajadores</h2>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Nombre(s)</label>
            <input type="text" id="name" name="name" class="form-control" value = "<?php echo htmlspecialchars($nombre); ?>" required>
        </div>

        <div class="mb-3">
            <label for="lastname" class="form-label">Apellido(s)</label>
            <input type="text" id="lastname" name="lastname" class="form-control" value = "<?php echo htmlspecialchars($apellido); ?>" required>
        </div>

        <div class="mb-3">
            <label for="dob" class="form-label">Fecha de Nacimiento</label>
            <input type="date" id="dob" name="dob" class="form-control" value = "<?php echo htmlspecialchars($fecha_nacimiento); ?>" required>
            <div id="dob-error" style="color: red; display: none;">Debes tener al menos 18 años.</div>
        </div>

        <div class="mb-3">
            <label for="city" class="form-label">Ciudad</label>
            <input type="text" id="city" name="city" class="form-control" value = "<?php echo htmlspecialchars($ciudad); ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" id="email" name="email" class="form-control" value = "<?php echo htmlspecialchars($email); ?>" required>
        </div>

        <div class="mb-3">
            <label for="emailConfirmar" class="form-label">Confirmar Correo Electrónico</label>
            <input type="email" id="emailConfirmar" name="emailConfirmar" class="form-control"  autocomplete="off" required>
        </div>

        
        <div class="mb-3">
            <label for="phone" class="form-label">Teléfono</label>
            <input type="tel" id="phone" name="phone" class="form-control" value = "<?php echo htmlspecialchars($telefono); ?>" required>
        </div>
        <div class="mb-3">
            <label for="phoneConfirmar" class="form-label">Confirmar Teléfono</label>
            <input type="tel" id="phoneConfirmar" name="phoneConfirmar" class="form-control" autocomplete="off" required>
        </div>
        <div class="form-check ">
            <input class="form-check-input" type="checkbox" value="1" id="flexCheckPrivacidad" name = "flexCheckPrivacidad" required>
                <label class="form-check-label" for="flexCheckPrivacidad">
                <p>He leído y acepto el Aviso de Privacidad.</p>
                </label>
        </div>
        <button type="submit" class="btn btn-primary w-100">Registrar y Continuar</button>
        <?php include('controller/controllerValidacionesRegistro.php'); ?>
    </form>
    <div class="mt-1 py-1">
        <a href="../login.php">Ya tengo usuario.</a>
    </div>

    <footer class="text-center mt-1 py-1">
    <a href="docs/PRIVACY POLICY-Jemo Contractor LLC.pdf">Jemo Contractor LLC 2025 | Aviso de Privacidad</a>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>