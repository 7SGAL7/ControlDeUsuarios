<?php

    session_start();
    if(empty($_SESSION["id"])){
        header("location: ../../login.php");
    }
    require '../bd/conection.php';


    $sql = "SELECT * FROM employees ORDER BY `employees`.`id`;";
    $result = $conn->query($sql);

?>

<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SISTEMA DE REGISTRO DE TRABAJADORES</title>
        <link rel="stylesheet" href="css/employees.css">
        <link rel="icon" type="image/png" href="icon/favicon/favicon-96x96.png" sizes="96x96" />
        <link rel="icon" type="image/svg+xml" href="icon/favicon//favicon.svg" />
        <link rel="shortcut icon" href="icon/favicon//favicon.ico" />
        <link rel="apple-touch-icon" sizes="180x180" href="icon/favicon//apple-touch-icon.png" />
        <link rel="manifest" href="icon/favicon//site.webmanifest" />
        <!-- Bootstrap core CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="librery/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="librery/css/dataTables.bootstrap5.css" rel="stylesheet" type="text/css">  
        <link rel="stylesheet" href="https://cdn.datatables.net/searchbuilder/1.7.0/css/searchBuilder.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">  
        <!-- Bootstrap core JS -->
        <script src="librery/js/bootstrap.bundle.min.js"></script>
        <script src="librery/js/jquery-3.7.1.js"></script>
        <script src="librery/js/dataTables.js"></script>
        <script src="librery/js/dataTables.bootstrap5.js"></script>
        <script src="https://cdn.datatables.net/searchbuilder/1.7.0/js/dataTables.searchBuilder.min.js"></script>

    </head>
    <body>
        <div class="container">
        <button onclick="history.back()" class="btn btn-outline-secondary">
            ⬅ Regresar
        </button>
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
        </div>

        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

        <script src = "json/descargarParcial.js">                  
        </script>
    </body>
</html>