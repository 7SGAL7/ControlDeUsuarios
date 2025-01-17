// Función para validar el login
function validarLogin(event) {
    event.preventDefault(); // Evitar que el formulario se envíe automáticamente

    // Obtener los valores de los campos
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    const errorMessage = document.getElementById("error-message");

    // Validación simple de usuario y contraseña
    if (username === "admin" && password === "12345") {
        // Si las credenciales son correctas
        errorMessage.style.display = "none"; // Ocultar mensaje de error
        
        // Redirigir a la página principal (o cualquier otra página)
        window.location.href = "pages/tableemployees.php"; // Cambia 'pagina-principal.html' por la página que deseas
    } else {
        // Si las credenciales son incorrectas
        errorMessage.style.display = "block"; // Mostrar mensaje de error
        errorMessage.textContent = "Usuario o contraseña incorrectos.";
    }
}