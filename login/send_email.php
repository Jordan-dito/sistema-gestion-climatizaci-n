<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Mostrar errores para depurar
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Encabezado para respuesta JSON (muy importante para fetch)
header('Content-Type: application/json');

// Autoload de PHPMailer
require 'vendor/autoload.php';

// Incluir archivo de conexión (ajusta la ruta si es necesario)
require '../app/config.php';
 // <-- Ruta relativa al archivo que contiene $pdo y $URL

$mail = new PHPMailer(true);
$response = [];

try {
    // Validación del campo email recibido
    if (!isset($_POST['email']) || empty($_POST['email'])) {
        throw new Exception('No se recibió el correo electrónico.');
    }

    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Email no válido.');
    }

    // Verificar si el email existe en la base de datos
    $stmt = $pdo->prepare("SELECT email FROM tb_usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $userExists = $stmt->fetchColumn();

    if (!$userExists) {
        throw new Exception('No existe una cuenta con ese correo electrónico.');
    }

    // Configuración de PHPMailer
  $mail->isSMTP();
$mail->Host = SMTP_HOST;
$mail->SMTPAuth = true;
$mail->Username = SMTP_USER;
$mail->Password = SMTP_PASS;
$mail->SMTPSecure = 'tls';
$mail->Port = SMTP_PORT;

$mail->setFrom(SMTP_USER, SMTP_FROM_NAME);
$mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Restablecimiento de Password';
    $mail->Body = '
        <h1>Restablecimiento de Password</h1>
        <p>Has solicitado restablecer tu contraseña. Haz clic en el siguiente enlace para continuar. Este enlace es válido por 24 horas.</p>
        <p><a href="' . $URL . '/login/procesar_reset.php">Restablecer contraseña</a></p>
        <p>Si no solicitaste este cambio, ignora este mensaje o contacta con soporte.</p>
    ';
    $mail->AltBody = 'Has solicitado restablecer tu contraseña. Enlace: ' . $URL . '/views/procesar_reset.php';

    $mail->send();
    $response['status'] = 'success';
    $response['message'] = 'El enlace de restablecimiento ha sido enviado a tu correo electrónico.';
} catch (Exception $e) {
    $response['status'] = 'error';
    $response['message'] = $e->getMessage();
}

// Enviar respuesta JSON al cliente (JavaScript)
echo json_encode($response);


?>

