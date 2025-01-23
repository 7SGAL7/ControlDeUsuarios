<?php
require '../bd/conection.php';

// Variable para almacenar errores


// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validación del campo 'name' (Nombre)
    if (empty($_POST['name'])) {
        $errores[] = "El nombre es obligatorio.";
    } else {
        $nombre = strtoupper($conn->real_escape_string(trim($_POST['name'])));
    }

    // Validación del campo 'lastname' (Apellido)
    if (empty($_POST['lastname'])) {
        $errores[] = "El apellido es obligatorio.";
    } else {
        $apellido = strtoupper($conn->real_escape_string(trim($_POST['lastname'])));
    }

    // Validación de la fecha de nacimiento (Fecha de Nacimiento)
    if (empty($_POST['dob'])) {
        $errores[] = "La fecha de nacimiento es obligatoria.";
    } else {
        $fecha_nacimiento = $_POST['dob'];
        // Verificar si la edad es mayor o igual a 18 años
        $fechaNacimiento = new DateTime($fecha_nacimiento);
        $hoy = new DateTime();
        $edad = $hoy->diff($fechaNacimiento)->y;
        if ($edad < 18) {
            $errores[] = "Debes tener al menos 18 años.";
        }
    }

    // Validación de la ciudad
    if (empty($_POST['city'])) {
        $errores[] = "La ciudad es obligatoria.";
    } else {
        $ciudad = strtoupper($conn->real_escape_string(trim($_POST['city'])));
    }

    // Validación del correo electrónico
    if (empty($_POST['email'])) {
        $errores[] = "El correo electrónico es obligatorio.";
    } else {
        $email = strtoupper($conn->real_escape_string(trim($_POST['email'])));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El correo electrónico no es válido.";
        }
    }

    // Validación de la confirmación de correo electrónico
    if (empty($_POST['emailConfirmar'])) {
        $errores[] = "Debes confirmar tu correo electrónico.";
    } else {
        $emailConfirmar = strtoupper($conn->real_escape_string(trim($_POST['emailConfirmar'])));
        if ($email !== $emailConfirmar) {
            $errores[] = "Los correos electrónicos no coinciden.";
        }
    }

    // Validación del teléfono
    if (empty($_POST['phone'])) {
        $errores[] = "El teléfono es obligatorio.";
    } else {
        $telefono = $conn->real_escape_string(trim($_POST['phone']));
        // Verificación de formato de teléfono (usaremos un formato básico)
        if (!preg_match("/^\d{10}$/", $telefono)) {
            $errores[] = "El teléfono debe tener 10 dígitos.";
        }
    }

    // Validación de la confirmación de teléfono
    if (empty($_POST['phoneConfirmar'])) {
        $errores[] = "Debes confirmar tu número de teléfono.";
    } else {
        $telefonoConfirmar = $conn->real_escape_string(trim($_POST['phoneConfirmar']));
        if ($telefono !== $telefonoConfirmar) {
            $errores[] = "Los números de teléfono no coinciden.";
        }
    }

    // Validación de la casilla de aceptación de privacidad
    if (!(isset($_POST['flexCheckPrivacidad']) && $_POST['flexCheckPrivacidad'] == '1')) {
        $errores[] = "Debes aceptar el Aviso de Privacidad.";
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

        // Preparar la consulta SQL para insertar los datos
        $sql = "INSERT INTO employees(Name, LastName, Matricula, Password, Birthdate, Phone, DateHiring, Email, City) 
                VALUES ('$nombre', '$apellido', '$matriz', '', '$fecha_nacimiento', '$telefono', '$dateWork', '$email', '$ciudad')";

        // Ejecutar la consulta
        if ($conn->query($sql) === TRUE) {
            // Guardar el dato en la sesión
            $_SESSION['matriz'] = $matriz;
            header("Location: sucessful.php");
            exit();
        } else {
            $errores[] = "Hubo un error al registrar los datos. Por favor, intenta nuevamente.";
        }
    }
}

// Cerrar la conexión a la base de datos
$conn->close();

// Si hay errores, mostrarlos
if (!empty($errores)) {
    echo "<p style='color: red;'>" . $error[0] . "</p>";
}
?>
