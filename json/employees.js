// Función para abrir el modal con los detalles del usuario
function verDetalles(nombre, telefono, fecha, correo, ciudad) {
    document.getElementById('detalleNombre').textContent = nombre;
    document.getElementById('detalleTelefono').textContent = telefono;
    document.getElementById('detalleFecha').textContent = fecha;
    document.getElementById('detalleCorreo').textContent = correo;
    document.getElementById('detalleCiudad').textContent = ciudad;
    document.getElementById('modal').style.display = "block";
}

// Función para cerrar el modal
function cerrarModal() {
    document.getElementById('modal').style.display = "none";
}

// Cerrar el modal si se hace clic fuera del contenido del modal
window.onclick = function(event) {
    if (event.target == document.getElementById('modal')) {
        cerrarModal();
    }
}
