<?php
require __DIR__ . '/../../../vendor/autoload.php';

use Twilio\Rest\Client;

class SmsService {
    private $client;
    private $from;

    public function __construct() {
        $env = parse_ini_file(__DIR__ . '/../../../.env');
        $twilioSid = $env['TWILIO_ACCOUNT_SID'];
        $twilioToken = $env['TWILIO_AUTH_TOKEN'];
        $twilioPhone = $env['TWILIO_PHONE_NUMBER'];
        $sid = $twilioSid; 
        $token = $twilioToken; 
        $this->from = $twilioPhone; // Número de Twilio

        $this->client = new Client($sid, $token);
    }

    public function enviarSms($numeros, $mensaje) {
        try {
            foreach ($numeros as $telefono) {
                $this->client->messages->create(
                    $telefono,
                    [
                        'from' => $this->from,
                        'body' => $mensaje
                    ]
                );
            }
            return "SMS enviado con éxito.";
        } catch (Exception $e) {
            return "Error al enviar SMS: " . $e->getMessage();
        }
    }
}


?>