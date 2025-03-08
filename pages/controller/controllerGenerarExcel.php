<?php

    session_start();
    if(empty($_SESSION["id"])){
        header("location: ../../login.php");
    }

    require '../../bd/conection.php';
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=registro de trabajadores.xls");

    $sql = "SELECT * FROM employees ORDER BY `employees`.`id`;";
    $result = $conn->query($sql);

?>

<table id="table-employees">
    <thead>
        <tr>
            <th>Numero Trabajador</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Fecha de nacimiento</th>
            <th>Telefono</th>
            <th>Correo</th>
            <th>Proyecto</th>
            <th>Fecha de ingreso</th>
            <th>Ciudad</th>
            <th>Direccion</th>
            <th>Firma contrato</th>
            <th>Tipo</th>
            <th>Clasificacion</th>
            <th>Hospedaje</th>
            <th>SSN</th>
            <th>Deposito directo</th>
            <th>Pay Rate</th>
            <th>Activo</th>
            <th>Comentarios</th>
        </tr>
    </thead>
    <tbody id="content">
        <?php 
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><?php echo $row['Matricula']; ?></td>
            <td><?php echo $row['Name']; ?></td>
            <td><?php echo $row['LastName']; ?></td>
            <td><?php 
            $fecha_original = $row['Birthdate']; 
            $fecha_objeto = DateTime::createFromFormat('Y-m-d', $fecha_original);
            echo $fecha_objeto->format('m/d/Y');  ?></td>
            <td><?php echo $row['Phone']; ?></td>
            <td><?php echo $row['Email']; ?></td>
            <td><?php echo $row['Proyect']; ?></td>
            <td><?php 
            $fecha_original = $row['DateHiring']; 
            $fecha_objeto = DateTime::createFromFormat('Y-m-d', $fecha_original);
            echo $fecha_objeto->format('m/d/Y'); 
            ?></td>
            <td><?php echo $row['City']; ?></td>
            <td><?php echo $row['Address']; ?></td>
            <td><?php 
                if($row['SIGN']){
                    echo "SI";
                }else{
                    echo "NO";
                }; 
            ?></td>
            <td><?php echo $row['type']; ?></td>
            <td><?php echo $row['classification']; ?></td>
            <td><?php if($row['lodging']){
                    echo "SI";
                }else{
                    echo "NO";
                };?></td>
            <td><?php echo $row['SSN']; ?></td>
            <td><?php 
            if($row['DirectDeposit']){
                echo "SI";
            }else{
                echo "NO";
            };?></td>
            <td><?php echo $row['PayRate']; ?></td>
            <td><?php 
            if($row['Active']){
                echo "SI";
            }else{
                echo "NO";
            };?></td>
            <td><?php echo $row['Comments']; ?></td>
        </tr>
        <?php  } } ?>
    </tbody>
</table>

