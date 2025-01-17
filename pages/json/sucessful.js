// Supongamos que el nombre de usuario es almacenado cuando se crea un nuevo usuario.
// Aquí tomamos ese nombre y lo mostramos en la página.

window.onload = function() {
    // Obtener el nombre del usuario desde un parámetro de la URL (si está disponible)
    const params = new URLSearchParams(window.location.search);
    const usuario = params.get('usuario');  // Suponemos que el nombre de usuario es pasado como parámetro

    // Mostrar el nombre del usuario en la página
    if (usuario) {
        document.getElementById("usuario").textContent = usuario;
    } else {
        // Si no hay un parámetro de usuario, mostramos un mensaje por defecto
        document.getElementById("usuario").textContent = "Usuario desconocido";
    }
}
