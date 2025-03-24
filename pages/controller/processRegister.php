<?php
/*require '../../bd/conection.php';

// Verificar si se han recibido los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener el último ID de empleados y calcular el nuevo ID
    $sql_id = "SELECT id FROM employees ORDER BY id DESC LIMIT 1;";
    $result = $conn->query($sql_id);

    if ($result->num_rows > 0) { 
        $row = $result->fetch_assoc();
        $id = $row['id'] + 1;
    } else {
        $id = 1;
    }

    // Capturar y procesar los datos del formulario
    $nombre = strtoupper($conn->real_escape_string($_POST['name']));
    $lastname = strtoupper($conn->real_escape_string($_POST['lastname']));
    $dob = $conn->real_escape_string($_POST['dob']);
    $city = strtoupper($conn->real_escape_string($_POST['city']));
    $correo = strtoupper($conn->real_escape_string($_POST['email']));
    $phone = $conn->real_escape_string($_POST['phone']);
    $matriz = substr($nombre, 0, 1) . substr($lastname, 0, 1) . str_pad($id, 3, "0", STR_PAD_LEFT);
    $dateWork = date("Y-m-d");


    // 🔍 **Validar si el correo o teléfono ya existen**
    $sql_check = "SELECT id FROM employees WHERE Email = ? OR Phone = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ss", $correo, $phone);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "❌ Error: El correo o teléfono ya están registrados.";
        exit();
    }


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
    $stmt->bind_param("sssssssss", $nombre, $lastname, $matriz, $password_hash, $dob, $phone, $dateWork, $correo, $city);

    if ($stmt->execute()) {
        session_start();
        $_SESSION['matriz'] = $matriz;
        header("Location: ../sucessful.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }




    // Insertar en la base de datos
    $sql = "INSERT INTO employees(Name, LastName, Matricula, Password, Birthdate, Phone, DateHiring, Email, City) 
            VALUES ('$nombre', '$lastname', '$matriz', '$password_hash', '$dob', '$phone', '$dateWork', '$correo', '$city')";

    if ($conn->query($sql) === TRUE) {
        session_start();
        $_SESSION['matriz'] = $matriz;
        header("Location: ../sucessful.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
*/

?>
