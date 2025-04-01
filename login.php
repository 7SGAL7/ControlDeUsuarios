<?php
    session_start();
    $username_value = '';
    $password_value = '';
    if (isset($_COOKIE['username'])) {
        $username_value = $_COOKIE['username'];  // Obtener el nombre de usuario de la cookie
    }
    if (isset($_COOKIE['password'])) {
        $password_value = $_COOKIE['password'];  // Obtener el nombre de usuario de la cookie
    }
    $tiempo_bloqueo = 10 * 60; 

    // Inicializar intentos si no existen
    if (!isset($_SESSION['intentos'])) {
        $_SESSION['intentos'] = 0;
    }

    // Comprobar si el usuario está bloqueado
    if (isset($_SESSION['bloqueo'])) {
        $tiempo_restante = ($_SESSION['bloqueo'] + $tiempo_bloqueo) - time();
        if ($tiempo_restante > 0) {
            header("location: pages/bloqueo.php");
        } else {
            // Si ya pasaron los 10 minutos, restablecer el bloqueo
            unset($_SESSION['bloqueo']);
            $_SESSION['intentos'] = 0;
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="pages/css/login.css">
    <link href="pages/librery/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="pages/librery/css/dataTables.bootstrap5.css" rel="stylesheet" type="text/css">  
    
    <link rel="icon" type="image/png" href="pages/icon/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="pages/icon/favicon//favicon.svg" />
    <link rel="shortcut icon" href="pages/icon/favicon//favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="pages/icon/favicon//apple-touch-icon.png" />
    <link rel="manifest" href="pages/icon/favicon//site.webmanifest" />
</head>
<body class="text-center">
    <form class="form-signin" method = "POST">
      <img class="mb-4" src="pages/img/JEMO-ICON.svg" alt="" width="100" height="100">
      <h1 class="h3 mb-3 font-weight-normal">Iniciar sesión</h1>

        <div class="d-flex justify-content-center mb-3">
            <input type="text" id="username"  name="username" class="form-control" placeholder="Username" required="" autofocus="" value = "<?php echo $username_value; ?>">
        </div>
        <div class="d-flex justify-content-center mb-3">
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required="" value = "<?php echo $password_value; ?>">
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" name="remember" <?php if (isset($_COOKIE['username'])) {echo "
            checked";}?>>
            <label class="form-check-label" for="flexCheckDefault">
                RECORDAR USUARIO
            </label>
        </div>

      <div>
          <input class="btn btn-lg btn-primary btn-block" type="submit" name = "login_form" value ="Iniciar sesión">
      </div class="checkbox mb-3">
 
      <div class="checkbox mb-3">
          <a href="pages/register.php">Registrate</a>
      </div>
      <div class="checkbox mb-3">
          <a href="pages/trabajadores/recuperacionpassword.php">Olvidé mi contraseña</a>
      </div>
        
        <div class="d-flex justify-content-center">
            <?php 
                include "bd/conection.php";
                include "pages/controller/controllerLogin.php";
                ?>
        </div>
    </form>
    
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
