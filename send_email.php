<?php
function getCredentials() {
    $output = shell_exec('powershell -Command "Import-Clixml -Path C:\ruta\al\archivo\credenciales.xml"');
    $xml = simplexml_load_string($output);
    
    $email = (string) $xml->UserName;
    $password = (string) $xml->GetNetworkCredential()->Password;

    return array("email" => $email, "password" => $password);
}

$credentials = getCredentials();

$email = $credentials['email'];
$password = $credentials['password'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $senderEmail = $_POST['email'];
    $message = $_POST['message'];
    
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP de Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $email; // Tu correo de Gmail
        $mail->Password = $password; // Tu contraseña de Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configuración del email
        $mail->setFrom($email, 'Remitente');
        $mail->addAddress('2820945@alu.murciaeduca.es'); // Tu dirección de correo
        $mail->Subject = 'Nuevo mensaje de contacto';
        $mail->Body = "Correo electrónico: $senderEmail\nMensaje:\n$message";

        $mail->send();
        echo 'Mensaje enviado con éxito.';
    } catch (Exception $e) {
        echo "Error al enviar el mensaje: {$mail->ErrorInfo}";
    }
}
?>
