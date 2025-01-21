function verDetalles(nombre, apellido, telefono, fechaNacimiento, correo, ciudad, matricula, proyecto, firma, ingreso, direccion, tipo, clasificacion, hospedaje, ssn, deposito, notas, id) {
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
    
}


var table = new DataTable('#table-employees', {
    language: {
        url: '//cdn.datatables.net/plug-ins/2.2.1/i18n/es-ES.json',
    },
    order: []
});


document.querySelector('.btn-update').addEventListener('click', function() {
    document.getElementById('formUsuario').submit();
});


