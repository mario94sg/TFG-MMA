<?php
session_start();
require_once 'database.php';
require_once '../mail/Envios.php';
header('Content-Type: application/json');

if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] !== 'alumno') {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Acceso denegado.']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['nombre']);
    $contrasena = trim($_POST['contrasena']);
    $correo_usuario = trim($_POST['correo']);

    if (empty($nombre) || empty($contrasena)) {
        echo json_encode(['success' => false, 'error' => 'Todos los campos son obligatorios.']);
        exit();
    }

    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $contrasena)) {
        echo json_encode(['success' => false, 'error' => 'La contraseña no cumple con los requisitos de seguridad.']);
        exit();
    }

    $id_usuario = $_SESSION['id_usuario'];
    $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

    try {
        $sql = "UPDATE usuarios SET nombre = ?, contrasena = ?, registrado = 1 WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $success = $stmt->execute([$nombre, $contrasenaHash, $id_usuario]);

        if ($success) {
            try {
                $asunto = "✅ ¡Datos actualizados con éxito! - MMA Tzinavos Team";
                $mensaje = '
                    <!DOCTYPE html>
                    <html lang="es">
                    <head>
                        <meta charset="UTF-8">
                        <style>
                            body { font-family: Arial, sans-serif; background-color: #f2f2f2; padding: 20px; }
                            .card { background: #fff; border-radius: 8px; padding: 30px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
                            .title { color: #4CAF50; font-size: 22px; font-weight: bold; margin-bottom: 20px; }
                            .footer { margin-top: 30px; font-size: 12px; color: #888; }
                        </style>
                    </head>
                    <body>
                        <div class="card">
                            <div class="title">Hola, tus datos se han actualizado correctamente 🙌</div>
                            <p>Ya puedes iniciar sesión con tu nombre introducido y tu nueva contraseña.</p>
                            <p>¡Gracias por formar parte de MMA Tzinavos Team! 🥋</p>
                            <div class="footer">Este es un correo automático. Por favor, no respondas a este mensaje.</div>
                        </div>
                    </body>
                    </html>
                ';

                $envios = new Envios();
                $envios->enviarMail($correo_usuario, $asunto, $mensaje);
            } catch (Exception $e) {
                // Error en el envío de correo no detiene el flujo
            }

            echo json_encode(['success' => true, 'redirect' => '/']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error al actualizar los datos.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Error de base de datos: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Acceso no permitido.']);
}
