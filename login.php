<?php
    $username_value = '';
    if (isset($_COOKIE['username'])) {
        $username_value = $_COOKIE['username'];  // Obtener el nombre de usuario de la cookie
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
    <link rel="icon" href="pages/img/JEMO-ICON.png">
</head>
<body class="text-center">
    <form class="form-signin" method = "POST">
      <img class="mb-4" src="pages/img/JEMO-ICON.svg" alt="" width="100" height="100">
      <h1 class="h3 mb-3 font-weight-normal">Iniciar sesión</h1>

        <div class="d-flex justify-content-center mb-3">
            <input type="text" id="username"  name="username" class="form-control" placeholder="Username" required="" autofocus="" value = "<?php echo $username_value; ?>">
        </div>
        <div class="d-flex justify-content-center mb-3">
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required="">
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
