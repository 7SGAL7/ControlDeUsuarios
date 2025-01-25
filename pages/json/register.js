
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