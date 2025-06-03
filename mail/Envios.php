<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "PHPMailer/src/Exception.php";
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/SMTP.php";

// Clase para envío de correos con PHPMailer
class Envios
{
    private $mail;

    // Constructor: configura el servidor SMTP
    public function __construct()
    {
        $this->mail = new PHPMailer(true);

        try {
            // CONFIGURACIÓN SMTP
            $this->mail->isSMTP();
            $this->mail->Host = 'smtp.ionos.es';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'support@tzinavosteam.online';
            $this->mail->Password = 'navalmanzano8';
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port = 587;

            // CONFIGURACIÓN GENERAL DEL CORREO
            $this->mail->setFrom('support@tzinavosteam.online', 'Support tzinavosteam');
            $this->mail->isHTML(true);
            $this->mail->CharSet = 'UTF-8';
        } catch (Exception $e) {
            return "Error de configuración del correo: " . $e->getMessage();
        }
    }

    // Método para enviar un correo electrónico
    public function enviarMail($destinatario, $asunto, $mensaje)
    {
        try {
            $this->mail->clearAllRecipients(); // Limpia destinatarios anteriores
            $this->mail->addAddress($destinatario); // Destinatario
            $this->mail->Subject = $asunto;
            $this->mail->Body = $mensaje;

            return $this->mail->send();
        } catch (Exception $e) {
            return false;
        }
    }
}
