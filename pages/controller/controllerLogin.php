<?php
session_start();

if(!empty($_POST["login_form"])){
    if (!empty($_POST["username"]) && !empty($_POST["password"])) {
        $user = $_POST["username"];
        $password = $_POST["password"];
        $acceso = "se accedio correctamente";

        if (isset($_POST['remember'])) {
            // Crear una cookie para recordar al usuario por 30 días (30 días * 24 horas * 60 minutos * 60 segundos)
            setcookie('username', $user, time() + (30 * 24 * 60 * 60), '/');
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
                echo "<script>console.log('" . $acceso . "');</script>";
                header("location: pages/tableemployees.php");
                exit();
            }else{
                echo "
                <div class='position-absolute alert alert-danger alert-danger fade show  mb-3' role='alert' >
                <strong>Usuario o contraseña incorrectos.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
                ";
            }
        }else{
            $sql = $conn->prepare("SELECT * FROM employees WHERE Matricula = ?");
            $sql->bind_param("s", $user);
            $sql->execute();
            $resultado = $sql->get_result();
            if($dato = $resultado->fetch_object()){
                $pass = $dato->Password;
                echo "<script>console.log('Hola $pass');</script>";
                echo "<script>console.log('Hola $password');</script>";
                if (password_verify($password, $dato->Password)) {
                    $_SESSION["idtrabajador"] = $dato->id;
                    $_SESSION["Nametrabajador"] = $dato->Name;
                    echo "<script>console.log('" . $acceso . "');</script>";
                    header("location: pages/trabajadores/trabajadoreseditar.php");
                    exit();
                }else{
                    echo "
                    <div class='position-absolute alert alert-danger alert-danger fade show  mb-3' role='alert' >
                    <strong>Usuario o contraseña incorrectos.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                    ";
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