<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Registro de Trabajadores</title>
    <link rel="icon" href="img/JEMO-ICON.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        header img {
            width: 150px;
        }

        form {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        form label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }


        form button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #0056b3;
        }

        .is-invalid {
            border: 1px solid red;
        }

        footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <header class="text-center">
        
    </header>
    <form action="controller/processRegister.php" method="POST" class="mt-4">
        <div class="mb-3" style = "text-align:center">
            <img src="img/JEMO-ICON.svg" alt="Logo de la Empresa" class="img-thumbnail" style="max-width: 60%;height: auto;">
            <h2>Registro de Trabajadores</h2>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Nombre Completo</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="lastname" class="form-label">Apellido</label>
            <input type="text" id="lastname" name="lastname" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="dob" class="form-label">Fecha de Nacimiento</label>
            <input type="date" id="dob" name="dob" class="form-control" required>
            <div id="dob-error" style="color: red; display: none;">Debes tener al menos 18 años.</div>
        </div>

        <div class="mb-3">
            <label for="city" class="form-label">Ciudad</label>
            <input type="text" id="city" name="city" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Teléfono</label>
            <input type="tel" id="phone" name="phone" class="form-control" required>
            <div id="phone-error" style="color: red; display: none;">Por favor, ingrese un número de teléfono válido.</div>
        </div>
        <div class="form-check ">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required>
                <label class="form-check-label" for="flexCheckDefault">
                <p>He leído y acepto el Aviso de Privacidad.</p>
                </label>
            </div>
            <div class="mb-3">
        
        </div>
        <button type="submit" class="btn btn-primary w-100">Registrar y Continuar</button>
    </form>
    <footer class="text-center mt-5 py-4">
    <a href="docs/PRIVACY POLICY-Jemo Contractor LLC.pdf">Jemo Contractor LLC 2025 | Aviso de Privacidad</a>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.querySelector('form').addEventListener('submit', function(event) {
            const dobInput = document.getElementById('dob');
            const dobError = document.getElementById('dob-error');
            const phoneInput = document.getElementById('phone');
            const phoneError = document.getElementById('phone-error');

            
            //Validar Fecha de nacimiento
            // Obtenemos la fecha actual
            const today = new Date();
            const birthDate = new Date(dobInput.value);
            
            // Calcular la diferencia en años
            let age = today.getFullYear() - birthDate.getFullYear();
            const month = today.getMonth() - birthDate.getMonth();
            if (month < 0 || (month === 0 && today.getDate() < birthDate.getDate())) {
                age--; // Si el cumpleaños no ha llegado este año, restamos un año
            }

            // Validar si la edad es mayor o igual a 18 años
            if (age >= 18) {
                dobError.style.display = 'none'; // Ocultar el mensaje de error si es válido
                dobInput.classList.remove('is-invalid'); // Eliminar la clase de error si es válido
            } else {
                event.preventDefault();
                dobError.style.display = 'block'; // Mostrar el mensaje de error
                dobInput.classList.add('is-invalid'); // Añadir la clase de error
            }
            // validar telefono 
            // Expresión regular para validar un número de teléfono (se puede personalizar según tu formato)
            const phoneRegex = /^\+?\d{1,4}[-\s]?\(?\d{1,3}\)?[-\s]?\d{3}[-\s]?\d{4}$/;

            // Verifica si el valor del input coincide con el regex
            if (!phoneRegex.test(phoneInput.value)) {
                phoneError.style.display = 'block'; // Muestra el mensaje de error
                phoneInput.classList.add('is-invalid'); // Agrega la clase para estilo de error (puedes agregar un estilo CSS si lo deseas)
            } else {
                event.preventDefault();
                phoneError.style.display = 'none'; // Oculta el mensaje de error
                phoneInput.classList.remove('is-invalid'); // Elimina la clase de error si es válido
            }
        });
    </script>
</body>
</html>