function verDetalles(nombre, telefono, fechaNacimiento, correo, ciudad, matricula) {
    // Asignar los valores a los elementos correspondientes en el modal
    document.getElementById('detalleNombre').textContent = nombre;
    document.getElementById('detalleTelefono').textContent = telefono;
    document.getElementById('detalleFecha').textContent = fechaNacimiento;
    document.getElementById('detalleCorreo').textContent = correo;
    document.getElementById('detalleCiudad').textContent = ciudad;
    document.getElementById('detalleTelefono').value = telefono;
    document.getElementById('nombre2').value = nombre;
}


var table = new DataTable('#table-employees', {
    language: {
        url: '//cdn.datatables.net/plug-ins/2.2.1/i18n/es-ES.json',
    },
});