<?php

if(!empty($_POST["login_form"])){
    if (!empty($_POST["username"]) && !empty($_POST["password"])) {
        $user = $_POST["username"];
        $password = $_POST["password"];

        if (isset($_POST['remember'])) {
            // Crear una cookie para recordar al usuario por 30 días (30 días * 24 horas * 60 minutos * 60 segundos)
            setcookie('username', $user, time() + (30 * 24 * 60 * 60), '/');
            setcookie('password', $password, time() + (30 * 24 * 60 * 60), '/');
        }

        $sql = $conn->prepare("SELECT * FROM jemoworkersusers WHERE User = ?");
        $sql->bind_param("s", $user);
        $sql->execute();
        $resultado = $sql->get_result();

        if ($dato = $resultado->fetch_object()) {
            // **Verificar contraseña hasheada**
            if (password_verify($password, $dato->Password)) {
                $_SESSION["id"] = $dato->id;
                $_SESSION["Name"] = $dato->Name;
                $_SESSION['intentos'] = 0; // Restablecer intentos en caso de éxito
                unset($_SESSION['bloqueo']);
                header("location: pages/tableemployees.php");
                exit();
            }else{
                $_SESSION['intentos']++;

                if ($_SESSION['intentos'] >= 3) {
                    $_SESSION['bloqueo'] = time(); // Guardar el momento del bloqueo
                    echo "
                    <div class='position-absolute alert alert-danger alert-danger fade show  mb-3' role='alert' >
                    <strong>⚠ Acceso bloqueado por 10 minutos. Demasiado intentos
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                } else {
                    echo "
                    <div class='position-absolute alert alert-danger alert-danger fade show  mb-3' role='alert' >
                    <strong>Usuario o contraseña incorrectos.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                    ";
                }
            }
        }else{
            $sql = $conn->prepare("SELECT * FROM employees WHERE Matricula = ?");
            $sql->bind_param("s", $user);
            $sql->execute();
            $resultado = $sql->get_result();
            if($dato = $resultado->fetch_object()){
                $pass = $dato->Password;
                if (password_verify($password, $dato->Password)) {
                    $_SESSION["idtrabajador"] = $dato->id;
                    $_SESSION["Nametrabajador"] = $dato->Name;
                    $_SESSION['intentos'] = 0; // Restablecer intentos en caso de éxito
                    unset($_SESSION['bloqueo']);
                    header("location: pages/trabajadores/trabajadoreseditar.php");
                    exit();
                }else{
                    $_SESSION['intentos']++;
                    if ($_SESSION['intentos'] >= 3) {
                        $_SESSION['bloqueo'] = time(); // Guardar el momento del bloqueo
                        echo "
                        <div class='position-absolute alert alert-danger alert-danger fade show  mb-3' role='alert' >
                        <strong>⚠ Acceso bloqueado por 10 minutos. Demasiado intentos
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
                    } else {
                        echo "
                        <div class='position-absolute alert alert-danger alert-danger fade show  mb-3' role='alert' >
                        <strong>Usuario o contraseña incorrectos.
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                        ";
                    }
                }
            }else{
                echo "
                <div class='position-absolute alert alert-danger alert-danger fade show  mb-3' role='alert' >
                <strong>Usuario o contraseña incorrectos.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
                ";
            }

        }
    }    
}


?>