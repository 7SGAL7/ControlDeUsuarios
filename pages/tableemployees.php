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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">  
        <!-- Bootstrap core JS -->
        <script src="librery/js/bootstrap.bundle.min.js"></script>
        <script src="librery/js/jquery-3.7.1.js"></script>
        <script src="librery/js/dataTables.js"></script>
        <script src="librery/js/dataTables.bootstrap5.js"></script>
        <script src="https://cdn.datatables.net/searchbuilder/1.7.0/js/dataTables.searchBuilder.min.js"></script>
        <script>
        function confirmarAccion() {
            let confirmacion = confirm("¿Estás seguro de realizar esta acción?");
            if (confirmacion) {
                alert("Acción confirmada.");
                // Aquí puedes agregar la acción a ejecutar si el usuario confirma
            } else {
                alert("Acción cancelada.");
            }
            }
        </script>
    </head>
    <body>

    <?php
        // Incluir el archivo de conexión
        require 'Menu.php';
        require '../bd/conection.php';
        $sql = "SELECT * FROM employees ORDER BY `employees`.`id` DESC;";
        $result = $conn->query($sql);

    ?>

        <div class="container">
            <h1>SISTEMA DE REGISTRO DE TRABAJADORES</h1>
            <a class="btn btn-outline-success" href ="controller/controllerGenerarExcel.php"><img src = "icon/flecha-descarga.png" style = "width:20px"></i> Descargar en Excel</a>
            <table id="table-employees">
                <thead>
                    <tr>
                        <th>Número Trabajador</th>
                        <th>Nombre(s)</th>
                        <th>Apellido(s)</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Proyecto</th>
                        <th>Firma contrato</th>
                        <th>Pay Rate</th>
                        <th>Clasificación</th>
                        <th></th>
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
                        <td><?php echo $row['Email']; ?></td>
                        <td><?php echo $row['Phone'];?></td>
                        <td><?php echo $row['Proyect']; ?></td>
                        <td><?php 
                            if($row['SIGN']){
                                echo "SI";
                            }else{
                                echo "NO";
                            }; 
                        ?></td>
                        <td><?php echo $row['PayRate']; ?></td>
                        <td><?php echo $row['classification']; ?></td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#InfoEmployee" onclick="verDetalles('<?php echo $row['Name'];?>', '<?php echo $row['LastName'];?>', '<?php echo $row['Phone']; ?>', '<?php echo $row['Birthdate']; ?>', '<?php echo $row['Email']; ?>', '<?php echo $row['City']; ?>', '<?php echo $row['Matricula']; ?>', '<?php echo $row['Proyect']; ?>', '<?php echo $row['SIGN']; ?>', '<?php echo $row['DateHiring']; ?>', '<?php echo $row['Address']; ?>', '<?php echo $row['type']; ?>', '<?php echo $row['classification']; ?>', '<?php echo $row['lodging']; ?>', '<?php echo $row['SSN']; ?>', '<?php echo $row['DirectDeposit']; ?>', '<?php echo $row['Comments']; ?>', '<?php echo $row['id']; ?>', '<?php echo $row['PayRate']; ?>', '<?php echo $row['Active']; ?>')">
                                Detalles
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
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content"> 
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Detalles del Trabajador <strong> <span id="matricula"></span></strong></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formUsuario" action="controller/controllerGuardarEmpleado.php" method="POST">
                            <input type="hidden" name="detalleID" id="detalleID">
                            <div class="mb-3">
                                <label class="form-label" for="detalleNombre">Nombre(s):</label>
                                <input class="form-control" type="text" id="detalleNombre" name="detalleNombre">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="detalleApellido">Apellido(s):</label>
                                <input class="form-control" type="text" id="detalleApellido" name="detalleApellido">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="detalleCorreo">Correo:</label>
                                <input class="form-control" type="text" id="detalleCorreo" name="detalleCorreo">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label" for="detalledireccion">Dirección</label>
                                <input class="form-control" type="text" id="detalledireccion" name="detalledireccion">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="detalleCiudad">Ciudad:</label>
                                <input class="form-control" type="text" id="detalleCiudad" name="detalleCiudad">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="detalleTelefono">Teléfono:</label>
                                <input class="form-control" type="text" id="detalleTelefono" name="detalleTelefono">
                            </div>
                            <div class="d-flex">
                                <div class="p-2 flex-fill">
                                    <label class="form-label" for="detalleFecha">Fecha de Nacimiento:<small></small></label>
                                    <input class="form-control" type="date" id="detalleFecha" name="detalleFecha">
                                </div>
                                <div class="p-2 flex-fill">
                                    <label class="form-label" for="detailDateHiring">Fecha Ingreso:</label>
                                    <input class="form-control" type="date" id="detailDateHiring" name="detailDateHiring">
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="p-2 flex-fill">
                                    <label class="form-label" for="detailSign">Firmo Contrato:</label>
                                    <select class="form-select" aria-label="Default select example" id = "detailSign" name="detailSign">
                                        <option value="0">No</option>
                                        <option value="1">Si</option>
                                    </select>
                                </div>
                                <div class="p-2 flex-fill">
                                <label class="form-label" for="detailhospedaje">Hospedaje:</label>
                                    <select class="form-select" aria-label="Default select example" id = "detailhospedaje" name="detailhospedaje">
                                        <option value="0">No</option>
                                        <option value="1">Si</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="detalleProyecto">Proyecto</label>
                                <input class="form-control" type="text" id="detalleProyecto" name="detalleProyecto">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="detalleTipo">Tipo</label>
                                <input class="form-control" type="text" id="detalleTipo" name="detalleTipo">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="detalleClasificacion">Clasificación</label>
                                <input class="form-control" type="text" id="detalleClasificacion" name="detalleClasificacion">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="detalleSSN">SSN</label>
                                <input class="form-control" type="text" id="detalleSSN" name="detalleSSN">
                            </div>
                            

                            <div class="d-flex">
                                <div class="p-2 flex-fill">
                                    <label class="form-label" for="detaildeposito">Deposito directo:</label>
                                    <select class="form-select" aria-label="Default select example" id = "detaildeposito" name="detaildeposito">
                                        <option value="0">No</option>
                                        <option value="1">Si</option>
                                    </select>
                                </div>
                                <div class="p-2 flex-fill">
                                    <label class="form-label" for="detailactivo">Activo:</label>
                                    <select class="form-select" aria-label="Default select example" id = "detailactivo" name="detailactivo">
                                        <option value="0">No</option>
                                        <option value="1">Si</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="detallePayRate">Pay Rate</label>
                                <input class="form-control" type="number" id="detallePayRate" name="detallePayRate">
                            </div>

                            <div>
                                <label class="form-label" for="DetailComment">Comentario:</label>
                                <textarea class="form-control" id="DetailComment" name="DetailComment"></textarea>
                            </div>

                            

                        </form>
                        <br>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal" onclick="$('#InfoEmployee').modal('hide'); EliminarTrabajador()">
                                Eliminar
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary btn-update">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        

        <!-- Modal de Confirmación -->
        <div class="modal fade" id="confirmModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Eliminar trabajador</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de que quieres eliminar al trabajador?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <form action="controller/controllerEliminarTrabajador.php" method="POST">
                            <input type="hidden" id="deleteUserId" name="deleteUserId">
                            <button type="submit" class="btn btn-danger">Sí, eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src = "json/employees.js">                  
        </script>


    </body>
</html>
