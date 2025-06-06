<?php
session_start();
require_once 'database.php';
require_once '../mail/Envios.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] !== 'entrenador') {
    http_response_code(403);
    echo "Acceso denegado.";
    exit();
}

if (!isset($_POST['nombre'], $_POST['email'], $_POST['contrasena'])) {
    http_response_code(400);
    echo "Datos incompletos.";
    exit();
}

$nombre = trim($_POST['nombre']);
$email = trim($_POST['email']);
$contrasenaPlano = trim($_POST['contrasena']);
$contrasenaHash = password_hash($contrasenaPlano, PASSWORD_DEFAULT);


$asunto = "👊 ¡Bienvenido a MMA Tzinavos Team! Tu cuenta ha sido creada";
$mensaje = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro exitoso</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f2f2f2; padding: 30px;">
    <div style="max-width: 600px; margin: auto; background-color: white; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); padding: 30px;">
        <h2 style="color: #d32f2f;">👊 Bienvenido a MMA Tzinavos Team, ' . htmlspecialchars($nombre) . '!</h2>
        <p>Has sido registrado exitosamente. Aquí tienes tus credenciales de Registro:</p>
        <ul>
            <li><strong>Nombre:</strong> ' . htmlspecialchars($nombre) . '</li>
            <li><strong>Email:</strong> ' . htmlspecialchars($email) . '</li>
            <li><strong>Contraseña:</strong> ' . htmlspecialchars($contrasenaPlano) . '</li>
        </ul>
        <p><strong>Una vez Registrado por primera vez por seguridad cambia tu contraseña y nombre si lo deseas.</strong></p>
        <p style="text-align: center;">
            <a href="https://tzinavosteam.online" style="background-color: #d32f2f; color: white; padding: 12px 20px; text-decoration: none; border-radius: 6px; font-weight: bold;">Acceder a la plataforma</a>
        </p>
        <hr style="margin-top: 30px;">
        <p style="font-size: 12px; color: #888;">Este mensaje fue enviado automáticamente. Si no solicitaste este registro, por favor ignóralo o contacta con tu entrenador.</p>
    </div>
</body>
</html>';

try {
    $sql = "INSERT INTO usuarios (nombre, email, contrasena, tipo, registrado) 
            VALUES (:nombre, :email, :contrasena, 'alumno', false)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':nombre' => $nombre,
        ':email' => $email,
        ':contrasena' => $contrasenaHash
    ]);

    $envios = new Envios();
    if ($envios->enviarMail($email, $asunto, $mensaje)) {
        echo "Alumno agregado y correo enviado correctamente.";
    } else {
        echo "Alumno agregado, pero error al enviar correo.";
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo "Error al agregar alumno: " . $e->getMessage();
}
