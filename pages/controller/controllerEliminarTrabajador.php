<?php
require '../../bd/conection.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteUserId'])) {
    $id = intval($_POST['deleteUserId']);

    $sql = "DELETE FROM employees WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../tableemployees.php");
        exit(); 
    } else {
        echo "<script>
                alert('Error al eliminar el empleado.');
                window.history.back(); // Volver a la página anterior
              </script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>
            alert('Solicitud inválida.');
            window.history.back();
          </script>";
}
?>
