<?php
session_start();
require_once 'database.php';
require_once '../mail/Envios.php';
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if (isset($_POST['email']) && isset($_POST['contrasena'])) {
    $email = trim($_POST['email']);
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT * FROM usuarios WHERE email = ? AND registrado = 1";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        $response['message'] = "Error en la preparación de la consulta: " . $conn->error;
        echo json_encode($response);
        exit();
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($contrasena, $usuario['contrasena'])) {
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['tipo'] = $usuario['tipo'];
            $_SESSION['email'] = $usuario['email'];

            $codigo_2fa = str_pad(random_int(0, 999999), 6, "0", STR_PAD_LEFT);
            $expira_timestamp = time() + 300; // 5 minutos


            $valor_cookie = $codigo_2fa . "|" . $expira_timestamp;

            setcookie('codigo_2fa', $valor_cookie, $expira_timestamp, "/", "", false, true);

            $asunto = "🔐 Verificación en dos pasos - MMA Tzinavos Team";
            $mensaje = '
                <!DOCTYPE html>
                <html lang="es">
                <head>
                    <meta charset="UTF-8">
                    <title>Verificación en dos pasos</title>
                </head>
                <body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 30px;">
                    <div style="max-width: 600px; margin: auto; background-color: white; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 30px;">
                        <h2 style="color: #d32f2f; text-align: center;">🔐 Verificación en dos pasos</h2>
                        <p style="text-align: center;">Has iniciado sesión en <strong>MMA Tzinavos Team</strong>.</p>
                        <p style="text-align: center;">Para continuar, introduce el siguiente código en la plataforma:</p>
                        <div style="text-align: center; margin: 20px 0;">
                            <span style="display: inline-block; background-color: #f2f2f2; color: #d32f2f; font-size: 36px; letter-spacing: 12px; padding: 10px 20px; border-radius: 10px; font-weight: bold;">' . $codigo_2fa . '</span>
                        </div>
                        <p style="text-align: center;">Este código caduca en 5 minutos.</p>
                        <hr style="margin-top: 30px;">
                        <p style="font-size: 12px; color: #888; text-align: center;">Si no has iniciado sesión, por favor contacta con tu entrenador o administrador.</p>
                    </div>
                </body>
                </html>
            ';

            $envios = new Envios();
            $envios->enviarMail($email, $asunto, $mensaje);

            $response['success'] = true;
            $response['message'] = "Inicio de sesión correcto. Verifica el código enviado al correo.";
        } else {
            $response['message'] = "Contraseña incorrecta.";
        }
    } else {
        $response['message'] = "Usuario no encontrado o no registrado.";
    }

    $stmt->close();
} else {
    $response['message'] = "Faltan datos del formulario.";
}

$conn->close();
echo json_encode($response);
