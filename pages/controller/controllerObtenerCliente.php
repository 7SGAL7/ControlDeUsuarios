<?php
require '../../bd/conection.php';

if (isset($_GET['proyecto_id'])) {
    $proyecto_id = $_GET['proyecto_id'];

    $sql = "SELECT * FROM employees WHERE Proyect = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $proyecto_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $clientes = [];
    while ($row = $result->fetch_assoc()) {
        $clientes[] = $row;
    }

    echo json_encode($clientes);
}
?>