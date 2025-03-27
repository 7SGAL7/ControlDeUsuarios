function verDetalles(nombre, apellido, telefono, fechaNacimiento, correo, ciudad, matricula, proyecto, firma, ingreso, direccion, tipo, clasificacion, hospedaje, ssn, deposito, notas, id, payrate, active, foto) {
    // Asignar los valores a los elementos correspondientes en el modal
    document.getElementById('detalleNombre').value = nombre;
    document.getElementById('detalleApellido').value = apellido;
    document.getElementById('detalleTelefono').value = telefono;
    document.getElementById('detalleFecha').value = fechaNacimiento;
    document.getElementById('detalleCorreo').value = correo;
    document.getElementById('detalleCiudad').value = ciudad;
    document.getElementById('matricula').textContent = matricula;


    document.getElementById('detalleProyecto').value = proyecto;
    document.getElementById('detailSign').value = firma;
    document.getElementById('detailDateHiring').value = ingreso;
    document.getElementById('detalledireccion').value = direccion;
    document.getElementById('detalleTipo').value = tipo;
    document.getElementById('detalleClasificacion').value = clasificacion;
    document.getElementById('detailhospedaje').value = hospedaje;
    document.getElementById('detalleSSN').value = ssn;
    document.getElementById('detaildeposito').value = deposito;
    document.getElementById('DetailComment').value = notas;
    document.getElementById('detalleID').value = id;
    document.getElementById('detallePayRate').value = payrate;
    document.getElementById('detailactivo').value = active;
    if (!foto || foto.trim() === "") {
        foto = "img/employeeicon.png"; // Imagen por defecto
    } else {
        foto = foto.replace("../", ""); // Remover '../' si la ruta existe
    }
    document.getElementById('previewImg').src = foto;
    console.log(foto);
}

/*
new DataTable('#table-employees', {
    language: {
        url: '//cdn.datatables.net/plug-ins/2.2.1/i18n/es-ES.json',
    },
    order: []
});*/

$(document).ready(function () {
    $('#table-employees').DataTable({
        dom: 'QBfrtip',  // 'Q' habilita el SearchBuilder
        searchBuilder: true, // Activa el filtrado avanzado
        buttons: [
            {
                extend: 'csv',
                text: 'Exportar CSV',
                filename: 'Empleados_Filtrados', // Nombre del archivo
                bom: true, // Agrega BOM para evitar problemas con caracteres especiales
                exportOptions: {
                    modifier: {
                        search: 'applied' // Exporta solo filas filtradas
                    },
                    columns: [0, 1, 2] // Exporta todas las columnas
                },
                customize: function (csv) {
                    return "Empleado,Edad del Trabajador,Cargo\n" + csv.split("\n").slice(1).join("\n");
                }
            }
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.0.0/i18n/es-ES.json',
            searchBuilder: {
                button: "Filtro avanzado",
                title: "Filtro avanzado"
            }
        },
        order: []
    });
});

//table.searchBuilder.container().prependTo(table.table().container());

document.querySelector('.btn-update').addEventListener('click', function() {
    document.getElementById('formUsuario').submit();
});


document.addEventListener('DOMContentLoaded', function () {
    let confirmModal = document.getElementById('confirmModal');

    confirmModal.addEventListener('hidden.bs.modal', function () {
        // Asegurar que el modal de InfoEmployee también se cierra si quedó abierto
        let infoModal = new bootstrap.Modal(document.getElementById('InfoEmployee'));
        infoModal.hide();
    });
});


function EliminarTrabajador(){
    let userId = document.getElementById("detalleID").value;
    document.getElementById("deleteUserId").value = userId;
}

function guardarEmpleado() {
    document.getElementById("formUsuario").submit();
}