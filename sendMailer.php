<?php 

require_once 'src/PHPMailer.php';
require_once 'src/SMTP.php';
require_once 'src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Dados do formulário
$destinatario = $_POST['destinatario'];
$assunto = $_POST['assunto'];
$mensagem = $_POST['mensagem'];

// Configuração do PHPMailer
$mail = new PHPMailer(true);

try {
    // Configuração do servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'laiic.business@gmail.com';
    $mail->Password = 'JoliaLaice125';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Configuração do e-mail
    $mail->setFrom('laiic.business@gmail.com', 'Edson Laice');
    $mail->addAddress($destinatario);
    $mail->Subject = $assunto;
    $mail->Body = $mensagem;
    $mail->AltBody = 'Versão de texto sem formatação para clientes de e-mail que não suportam HTML';

    // Enviar e-mail
    $mail->send();
    header("location: borrower.php");
} catch (Exception $e) {
    echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
}
?>

