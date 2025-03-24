<?php
    require '../bd/conection.php';

    // Variable para almacenar errores
    $errores = [];
    $nombre = $apellido = $fecha_nacimiento = $ciudad = $email = $telefono = $confirmemail = $confirmtelefono = '';
    $nombreErr = $apellidoErr = $fechaErr = $ciudadErr = $emailErr = $telefonoErr = $confirmemailErr = $confirmtelefonoErr = $privacidadError = "";

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Validación del campo 'name' (Nombre)
    if (empty($_POST['name'])) {
        $nombreErr = "El nombre es obligatorio.";
        $errores[] = $nombreErr;
    } else {
        $nombreErr = '';
        $nombre = strtoupper($conn->real_escape_string(trim($_POST['name'])));
    }

    // Validación del campo 'lastname' (Apellido)
    if (empty($_POST['lastname'])) {
        $apellidoErr = "El apellido es obligatorio.";
        $errores[] = $apellidoErr;
        
    } else {
        $apellidoErr = '';
        $apellido = strtoupper($conn->real_escape_string(trim($_POST['lastname'])));
    }

    // Validación de la fecha de nacimiento (Fecha de Nacimiento)
    if (empty($_POST['dob'])) {
        $fechaErr = "La fecha de nacimiento es obligatoria.";
        $errores[] = $fechaErr;
    } else {
        $fecha_nacimiento = $_POST['dob'];
        // Verificar si la edad es mayor o igual a 18 años
        $fechaNacimiento = new DateTime($fecha_nacimiento);
        $hoy = new DateTime();
        $edad = $hoy->diff($fechaNacimiento)->y;
        if ($edad < 18) {
            $fechaErr = "Debes tener al menos 18 años.";
            $errores[] = $fechaErr;
        }else{
            $fechaErr = '';
        }
    }

    // Validación de la ciudad
    if (empty($_POST['city'])) {
        $ciudadErr = "La ciudad es obligatoria.";
        $errores[] = $ciudadErr;
    } else {
        $ciudadErr = '';
        $ciudad = strtoupper($conn->real_escape_string(trim($_POST['city'])));
    }

    // Validación del correo electrónico
    if (empty($_POST['email'])) {
        $emailErr = "El correo electrónico es obligatorio.";
        $errores[] =   $emailErr ;
    } else {
        $email = strtoupper($conn->real_escape_string(trim($_POST['email'])));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "El correo electrónico no es válido.";
            $errores[] =   $emailErr;
        }else{
            $emailErr = '';
        }
    }

    // Validación de la confirmación de correo electrónico
    if (empty($_POST['emailConfirmar'])) {
        $confirmemailErr = "Debes confirmar tu correo electrónico.";
        $errores[] = $confirmemailErr;
    } else {
        $confirmemail = strtoupper($conn->real_escape_string(trim($_POST['emailConfirmar'])));
        if ($email !== $confirmemail) {
            $confirmemailErr = "Los correos electrónicos no coinciden.";
            $errores[] = $confirmemailErr;
        }else{
            $confirmemailErr = '';
        }
    }

    // Validación del teléfono
    if (empty($_POST['phone'])) {
        $telefonoErr = "El teléfono es obligatorio.";
        $errores[] = $telefonoErr;
    } else {
        $telefono = $conn->real_escape_string(trim($_POST['phone']));
        // Verificación de formato de teléfono (usaremos un formato básico)
        if (!preg_match("/^\d{10}$/", $telefono)) {
            $telefonoErr ="El teléfono debe tener 10 dígitos.";
            $errores[] = $telefonoErr;
        }else{
            $telefonoErr = '';
        }
    }

    // Validación de la confirmación de teléfono
    if (empty($_POST['phoneConfirmar'])) {
        $confirmtelefonoErr = "Debes confirmar tu número de teléfono.";
        $errores[] = $confirmtelefonoErr;
    } else {
        $confirmtelefono = $conn->real_escape_string(trim($_POST['phoneConfirmar']));
        if ($telefono !== $confirmtelefono) {
            $confirmtelefonoErr = "Los números de teléfono no coinciden.";
            $errores[] = $confirmtelefonoErr;
        }else{
            $confirmtelefonoErr = '';
        }
    }

    // Validación de la casilla de aceptación de privacidad
    if (!(isset($_POST['flexCheckPrivacidad']) && $_POST['flexCheckPrivacidad'] == '1')) {
        $privacidadError = "Debes aceptar el Aviso de Privacidad.";
        $errores[] = $privacidadError;
    }else{
       $privacidadError = '';
    }


    // 🔍 **Validar si el correo ya existe**
    $sql_check_email = "SELECT id FROM employees WHERE Email = ?";
    $stmt_check_email = $conn->prepare($sql_check_email);
    $stmt_check_email->bind_param("s", $email);
    $stmt_check_email->execute();
    $stmt_check_email->store_result();

    if ($stmt_check_email->num_rows > 0) {
        $emailErr = "El correo ya está registrado.";
        $errores[] = $emailErr;
    }

    // 🔍 **Validar si el teléfono ya existe**
    $sql_check_phone = "SELECT id FROM employees WHERE Phone = ?";
    $stmt_check_phone = $conn->prepare($sql_check_phone);
    $stmt_check_phone->bind_param("s", $telefono);
    $stmt_check_phone->execute();
    $stmt_check_phone->store_result();

    if ($stmt_check_phone->num_rows > 0) {
        $telefonoErr = "El teléfono ya está registrado.";
        $errores[] =  $telefonoErr;
    }

    // Si no hay errores, proceder con la inserción en la base de datos
    if (empty($errores)) {
        // Obtener el último ID de empleado y crear el nuevo ID
        $sql_id = "SELECT id FROM employees ORDER BY id DESC LIMIT 1;";
        $result = $conn->query($sql_id);

        if ($result->num_rows > 0) { 
            $row = $result->fetch_assoc();
            $id = $row['id'] + 1;
        } else {
            $id = 1;
        }

        // Crear la matrícula
        $matriz = substr($nombre, 0, 1) . substr($apellido, 0, 1) . str_pad($id, 3, "0", STR_PAD_LEFT);
        $dateWork = date("Y-m-d");

        // 🔐 Generar una contraseña aleatoria segura
        function generarContrasena($longitud = 5) {
            $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
            return substr(str_shuffle($caracteres), 0, $longitud);
        }

        $password_plana = generarContrasena();  // Contraseña sin encriptar
        $password_hash = password_hash($password_plana, PASSWORD_DEFAULT);


        $sql = "INSERT INTO employees (Name, LastName, Matricula, Password, Birthdate, Phone, DateHiring, Email, City) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss", $nombre, $apellido, $matriz, $password_hash, $fecha_nacimiento, $telefono, $dateWork, $email, $ciudad);

        if ($stmt->execute()) {
            session_start();
            $_SESSION['matriz'] = $matriz;
            header("Location: sucessful.php");
            exit();
        } else {
            $errores[] = "Hubo un error al registrar los datos. Por favor, intenta nuevamente.";
        }

        /*
        // Preparar la consulta SQL para insertar los datos
        $sql = "INSERT INTO employees(Name, LastName, Matricula, Password, Birthdate, Phone, DateHiring, Email, City) 
                VALUES ('$nombre', '$apellido', '$matriz', $password_hash, '$fecha_nacimiento', '$telefono', '$dateWork', '$email', '$ciudad')";

        // Ejecutar la consulta
        if ($conn->query($sql) === TRUE) {
            // Guardar el dato en la sesión
            session_start();
            $_SESSION['matriz'] = $matriz;
            header("Location: sucessful.php");
            exit();
        } else {
            $errores[] = "Hubo un error al registrar los datos. Por favor, intenta nuevamente.";
        }*/
    }
}

/*
// Si hay errores, mostrarlos
if (!empty($errores)) {
    foreach ($errores as $error) {
        echo "<p style='color: red;'>" . $error . "</p>";
    }
   
}*/

    // Cerrar la conexión a la base de datos
    $conn->close();
?>
