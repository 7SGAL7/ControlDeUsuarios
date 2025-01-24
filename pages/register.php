<?php 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Registro de Trabajadores</title>
    <link rel="icon" type="image/png" href="icon/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="icon/favicon//favicon.svg" />
    <link rel="shortcut icon" href="icon/favicon//favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="icon/favicon//apple-touch-icon.png" />
    <link rel="manifest" href="icon/favicon//site.webmanifest" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <form  method="POST" class="mt-4" id = "form-register" action="controller/controllerValidacionesRegistro.php">
        <div class="mb-3 espaciado-main">
        </div>
        <div class="mb-3" style = "text-align:center">
            <img src="img/JEMO-ICON.svg" alt="Jemo Contractor LLC" class="img-fluid">
            
            <h2>Registro de Trabajadores</h2>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Nombre(s)</label>
            <input type="text" id="name" name="name" class="form-control" required>
            <div id="name-error" style="color: red; display: none;">El nombre es obligatorio.</div>
        </div>

        <div class="mb-3">
            <label for="lastname" class="form-label">Apellido(s)</label>
            <input type="text" id="lastname" name="lastname" class="form-control" required>
            <div id="lastname-error" style="color: red; display: none;">El Apellido es obligatorio.</div>
        </div>

        <div class="mb-3">
            <label for="dob" class="form-label">Fecha de Nacimiento</label>
            <input type="date" id="dob" name="dob" class="form-control" required>
            <div id="dob-error" style="color: red; display: none;">Debes tener al menos 18 años.</div>
        </div>

        <div class="mb-3">
            <label for="city" class="form-label">Ciudad</label>
            <input type="text" id="city" name="city" class="form-control" required>
            <div id="city-error" style="color: red; display: none;">La ciudad es obligatoria.</div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" id="email" name="email" class="form-control" required>
            <div id="email-error" style="color: red; display: none;">El correo electrónico no es válido.</div>
        </div>

        <div class="mb-3">
            <label for="emailConfirmar" class="form-label">Confirmar Correo Electrónico</label>
            <input type="email" id="emailConfirmar" name="emailConfirmar" class="form-control"  autocomplete="off" required>
            <div id="emailConfirmar-error" style="color: red; display: none;">Los correos electrónicos no coinciden.</div>
        </div>

        
        <div class="mb-3">
            <label for="phone" class="form-label">Teléfono</label>
            <input type="tel" id="phone" name="phone" class="form-control" required>
            <div id="phone-error" style="color: red; display: none;">El teléfono debe tener 10 dígitos.</div>
        </div>
        <div class="mb-3">
            <label for="phoneConfirmar" class="form-label">Confirmar Teléfono</label>
            <input type="tel" id="phoneConfirmar" name="phoneConfirmar" class="form-control" autocomplete="off" required>
            <div id="phoneConfirmar-error" style="color: red; display: none;">Los teléfonos no coinciden.</div>
        </div>
        <div class="form-check ">
            <input class="form-check-input" type="checkbox" value="1" id="flexCheckPrivacidad" name = "flexCheckPrivacidad" required>
                <label class="form-check-label" for="flexCheckPrivacidad">
                <p>He leído y acepto el Aviso de Privacidad.</p>
                </label>
                <div id="priv-error" style="color: red; display: none;">Debes aceptar el Aviso de Privacidad.</div>
                
        </div>
        <button type="submit" class="btn btn-primary w-100">Registrar y Continuar</button>
        
    </form>
    <div class="mt-1 py-1">
        <a href="../login.php">Ya tengo usuario.</a>
    </div>

    <footer class="text-center mt-1 py-1">
    <a href="docs/PRIVACY POLICY-Jemo Contractor LLC.pdf">Jemo Contractor LLC 2025 | Aviso de Privacidad</a>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>    

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector("form");
            form.addEventListener("submit", function(event) {
                let valid = true;
                // Validación del campo 'name' (Nombre)
                const name = document.getElementById("name").value.trim();
                const nameError = document.getElementById("name-error");
                if (name === "") {
                    nameError.textContent = "El nombre es obligatorio.";
                    nameError.style.display = "block";
                    valid = false;
                } else {
                    nameError.style.display = "none";
                }

                // Validación del campo 'lastname' (Apellido)
                const lastname = document.getElementById("lastname").value.trim();
                const lastnameError = document.getElementById("lastname-error");
                if (lastname === "") {
                    lastnameError.textContent = "El apellido es obligatorio.";
                    lastnameError.style.display = "block";
                    valid = false;
                } else {
                    lastnameError.style.display = "none";
                }

                // Validación de la fecha de nacimiento (Fecha de Nacimiento)
                const dob = document.getElementById("dob").value;
                const dobError = document.getElementById("dob-error");
                if (dob === "") {
                    dobError.textContent = "La fecha de nacimiento es obligatoria.";
                    dobError.style.display = "block";
                    valid = false;
                } else {
                    const birthDate = new Date(dob);
                    const today = new Date();
                    const age = today.getFullYear() - birthDate.getFullYear();
                    const m = today.getMonth() - birthDate.getMonth();

                    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                        age--;
                    }

                    if (age < 18) {
                        dobError.textContent = "Debes tener al menos 18 años.";
                        dobError.style.display = "block";
                        valid = false;
                    } else {
                        dobError.style.display = "none";
                    }
                }

                // Validación de la ciudad
                const city = document.getElementById("city").value.trim();
                const cityError = document.getElementById("city-error");
                if (city === "") {
                    cityError.textContent = "La ciudad es obligatoria.";
                    cityError.style.display = "block";
                    valid = false;
                } else {
                    cityError.style.display = "none";
                }

                // Validación del correo electrónico
                const email = document.getElementById("email").value.trim();
                const emailError = document.getElementById("email-error");
                if (email === "") {
                    emailError.textContent = "El correo electrónico es obligatorio.";
                    emailError.style.display = "block";
                    valid = false;
                } else if (!validateEmail(email)) {
                    emailError.textContent = "El correo electrónico no es válido.";
                    emailError.style.display = "block";
                    valid = false;
                } else {
                    emailError.style.display = "none";
                }

                // Validación de la confirmación de correo electrónico
                const emailConfirmar = document.getElementById("emailConfirmar").value.trim();
                const emailConfirmError = document.getElementById("emailConfirmar-error");
                if (emailConfirmar === "") {
                    emailConfirmError.textContent = "Debes confirmar tu correo electrónico.";
                    emailConfirmError.style.display = "block";
                    valid = false;
                } else if (email !== emailConfirmar) {
                    emailConfirmError.textContent = "Los correos electrónicos no coinciden.";
                    emailConfirmError.style.display = "block";
                    valid = false;
                } else {
                    emailConfirmError.style.display = "none";
                }

                // Validación del teléfono
                const phone = document.getElementById("phone").value.trim();
                const phoneError = document.getElementById("phone-error");
                if (phone === "") {
                    phoneError.textContent = "El teléfono es obligatorio.";
                    phoneError.style.display = "block";
                    valid = false;
                } else if (!/^\d{10}$/.test(phone)) {
                    phoneError.textContent = "El teléfono debe tener 10 dígitos.";
                    phoneError.style.display = "block";
                    valid = false;
                } else {
                    phoneError.style.display = "none";
                }

                // Validación del teléfono confirmado
                const phoneConfirmar = document.getElementById("phoneConfirmar").value.trim();
                const phoneConfirmError = document.getElementById("phoneConfirmar-error");
                if (phoneConfirmar === "") {
                    phoneConfirmError.textContent = "Debes confirmar tu teléfono.";
                    phoneConfirmError.style.display = "block";
                    valid = false;
                } else if (phone !== phoneConfirmar) {
                    phoneConfirmError.textContent = "Los teléfonos no coinciden.";
                    phoneConfirmError.style.display = "block";
                    valid = false;
                } else {
                    phoneConfirmError.style.display = "none";
                }

                // Validación del checkbox de privacidad
                const privacidad = document.getElementById("flexCheckPrivacidad").checked;
                const privError = document.getElementById("priv-error");
                if (!privacidad) {
                    privError.textContent = "Debes aceptar el Aviso de Privacidad.";
                    privError.style.display = "block";
                    valid = false;
                } else {
                    privError.style.display = "none";
                }

                // Si alguna validación falla, prevenir el envío del formulario
                if (!valid) {
                    event.preventDefault();
                }
            });

            // Función para validar formato de correo electrónico
            function validateEmail(email) {
                const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                return re.test(email);
            }
        });

    </script>

</body>
</html>