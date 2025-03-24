<?php
require 'vendor/autoload.php';

use Twilio\Rest\Client;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $empleados = $_POST['empleados'];
    $mensaje = $_POST['mensaje'];

    $sid = 'TU_TWILIO_SID'; 
    $token = 'TU_TWILIO_TOKEN'; 
    $twilio = new Client($sid, $token);

    foreach ($empleados as $emp) {
        $twilio->messages->create(
            $emp['telefono'],
            [
                'from' => 'TU_NUMERO_TWILIO',
                'body' => $mensaje
            ]
        );
    }

    echo "Mensajes SMS enviados exitosamente.";
}
?>
