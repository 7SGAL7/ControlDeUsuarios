<?php
    session_start();
    if(empty($_SESSION["id"])){
        header("location: ../login.php");
    }
?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tabla de Información</title>
        <link rel="stylesheet" href="css/employees.css">
        <!-- Bootstrap core CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="librery/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="librery/css/dataTables.bootstrap5.css" rel="stylesheet" type="text/css">    
        <!-- Bootstrap core JS -->
        <script src="librery/js/bootstrap.bundle.min.js"></script>
        <script src="librery/js/jquery-3.7.1.js"></script>
        <script src="librery/js/dataTables.js"></script>
        <script src="librery/js/dataTables.bootstrap5.js"></script>
    </head>
    <body>

    <?php
        // Incluir el archivo de conexión
        require '../bd/conection.php';
        $sql = "SELECT * FROM employees";
        $result = $conn->query($sql);

        echo $_SESSION["Name"];
    ?>

        <div class="container">
            <h1>Información de Contacto</h1>

            
            <table id="table-employees" style="width:100%">
                <thead>
                    <tr>
                        <th>Clave de empleado</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Fecha de Inicio</th>
                        <th>Detalles</th>
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
                        <td><?php echo $row['Phone']; ?></td>
                        <td><?php echo $row['Email']; ?></td>
                        <td><?php echo $row['DateHiring']; ?></td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#InfoEmployee" onclick="verDetalles('<?php echo $row['Name'] . ' ' . $row['LastName'];?>', '<?php echo $row['Phone']; ?>', '<?php echo $row['Birthdate']; ?>', '<?php echo $row['Email']; ?>', '<?php echo $row['City']; ?>', '<?php echo $row['Matricula']; ?>')">
                                Editar
                            </button>
                        </td>
                    </tr>
                    <?php  } } ?>
                </tbody>
            </table>
            <div class="row justify-content-between">

                <div class="col-12 col-md-4">
                    <label id="lbl-total"></label>
                </div>

                <div class="col-12 col-md-4" id="nav-paginacion"></div>

                <input type="hidden" id="pagina" value="1">
                <input type="hidden" id="orderCol" value="0">
                <input type="hidden" id="orderType" value="asc">

            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="InfoEmployee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Detalles del Usuario</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Nombre:</strong> <span id="detalleNombre"></span></p>
                        <p><strong>Correo:</strong> <span id="detalleCorreo"></span></p>
                        <p><strong>Fehca de Nacimiento:</strong> <span id="detalleFecha"></span></p>
                        <p><strong>Ciudad:</strong> <span id="detalleCiudad"></span></p>
                        <form id="formUsuario">
                            <div class="mb-3">
                                <label class="form-label" for="detalleTelefono">Phone:</label>
                                <input class="form-control" type="text" id="detalleTelefono" name="detalleTelefono" required>
                            </div>
                            <div class="d-flex">
                                <div class="p-2 flex-fill">
                                    <label class="form-label" for="detailDateHiring">Date Hiring:</label>
                                    <input class="form-control" type="date" id="detailDateHiring" name="detailDateHiring" required>
                                </div>
                                <div class="p-2 flex-fill">
                                    <label class="form-label" for="detailEndHiring">End Hiring:<small></small></label>
                                    <input class="form-control" type="date" id="detailEndHiring" name="detailEndHiring" required>
                                </div>
                            </div>
                            <div class="mb-3 form-check">
                                <label class="form-label"for="DetailSign">Sign</label>
                                <input class="form-check-input" type="checkbox" id="DetailSign" name="DetailSign" required>
                            </div>
                            <div>
                                <label class="form-label" for="DetailComment">Comentario:</label>
                                <textarea class="form-control" id="DetailComment" name="DetailComment" required></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>


        <a href="controller/controllerCerrarSesion.php">Cerrar sesión</a>
        <script src = "json/employees.js">                  

        </script>


    </body>
</html>
