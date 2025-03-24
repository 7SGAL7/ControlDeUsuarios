<?php
$conexion = new mysqli("localhost", "root", "", "mi_base_de_datos");

if ($_FILES['imagen']['error'] == 0) {
    $imagen_nombre = basename($_FILES['imagen']['name']);
    $ruta = "uploads/" . $imagen_nombre;

    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta)) {
        $sql = "INSERT INTO imagenes (ruta) VALUES ('$ruta')";
        if ($conexion->query($sql)) {
            echo "Imagen subida y guardada en la base de datos.";
        } else {
            echo "Error al guardar en la base de datos.";
        }
    } else {
        echo "Error al mover la imagen.";
    }
} else {
    echo "Error en la subida de la imagen.";
}
?>

<form action="upload.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="imagen" required>
    <input type="submit" value="Subir Imagen">
</form>

<?php
$conexion = new mysqli("localhost", "root", "", "mi_base_de_datos");
$resultado = $conexion->query("SELECT * FROM imagenes");

while ($fila = $resultado->fetch_assoc()) {
    echo '<img src="data:image/jpeg;base64,' . base64_encode($fila['imagen']) . '" width="200"><br>';
}





$sql = $conn->prepare("SELECT * FROM employees WHERE Matricula = ?");
            $sql->bind_param("s", $user);
            $sql->execute();
            $resultado = $sql->get_result();

            if($dato = $resultado->fetch_object()){
                if (password_verify($password, $dato->Password)) {
                    $_SESSION["id"] = $dato->id;
                    $_SESSION["Name"] = $dato->Name;
                    echo "<script>console.log('" . $acceso . "');</script>";
                    header("location: pages/tableemployees.php");
                    exit();
                }
            }
?>