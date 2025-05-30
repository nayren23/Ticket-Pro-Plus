<?php

namespace TicketProPlus\App\Core\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private string $host;
    private string $username;
    private string $password;
    private int $port;
    private string $encryption;
    private string $fromEmail;
    private string $fromName;

    public function __construct()
    {
        if (
            !isset(
                $_ENV['SMTP_HOST'],
                $_ENV['SMTP_USERNAME'],
                $_ENV['SMTP_PASSWORD'],
                $_ENV['SMTP_PORT'],
                $_ENV['SMTP_ENCRYPTION'],
                $_ENV['SMTP_FROM_EMAIL'],
                $_ENV['SMTP_FROM_NAME']
            )
        )
            throw new \InvalidArgumentException('Variables d\'environnement SMTP manquantes. Assurez-vous que votre fichier .env est chargé.');

        $this->host = $_ENV['SMTP_HOST'];
        $this->username = $_ENV['SMTP_USERNAME'];
        $this->password = $_ENV['SMTP_PASSWORD'];
        $this->port = (int) $_ENV['SMTP_PORT'];
        $this->encryption = $_ENV['SMTP_ENCRYPTION'];
        $this->fromEmail = $_ENV['SMTP_FROM_EMAIL'];
        $this->fromName = $_ENV['SMTP_FROM_NAME'];
    }

    public function send(string $toEmail, string $toName, string $subject, string $bodyHtml, string $bodyText = ''): bool
    {
        $mail = new PHPMailer(true);

        try {
            // Configuration du serveur SMTP
            $mail->SMTPDebug = 0; // Set to 2 for verbose debugging
            $mail->isSMTP();
            $mail->Host = $this->host;
            $mail->SMTPAuth = true;
            $mail->Username = $this->username;
            $mail->Password = $this->password;
            $mail->SMTPSecure = $this->encryption;
            $mail->Port = $this->port;
            $mail->CharSet = 'UTF-8';

            // Expéditeur et Destinataire
            $mail->setFrom($this->fromEmail, $this->fromName);
            $mail->addAddress($toEmail, $toName);

            // Contenu de l'email
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $bodyHtml;
            if (!empty($bodyText)) {
                $mail->AltBody = $bodyText; // Corps de texte brut qui ne supportent pas HTML
            }
            $mail->send();
            return true;
        } catch (Exception $e) {
            echo ("Erreur lors de l'envoi de l'email à {$toEmail}: {$mail->ErrorInfo}");
            return false;
        }
    }
}
