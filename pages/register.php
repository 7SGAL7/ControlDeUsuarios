<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Trabajadores</title>
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
    <header>
        <img src="logo.png" alt="Logo de la Empresa">
        <h1>Registro de Trabajadores</h1>
    </header>
    <form action="logic/processRegister.php" method="POST">
        <label for="name">Nombre Completo</label>
        <input type="text" id="name" name="name" required>

        <label for="name">Last Name</label>
        <input type="text" id="lastname" name="lastname" required>

        <label for="dob">Birthdate</label>
        <input type="date" id="dob" name="dob" required>

        <label for="city">Ciudad</label>
        <input type="text" id="city" name="city" required>

        <label for="email">Correo Electrónico</label>
        <input type="email" id="email" name="email" required>

        <label for="phone">Teléfono</label>
        <input type="tel" id="phone" name="phone" required>

        <button type="submit">Registrar y Continuar</button>
    </form>

    <footer>
        <p>&copy; 2025 JemoWorkers. Todos los derechos reservados.</p>
    </footer>

    <script>
        document.querySelector('form').addEventListener('submit', function(event) {
            // Aquí se puede agregar lógica de validación adicional si es necesario.
        });
    </script>
</body>
</html>