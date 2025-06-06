<?php
session_start();
require 'database.php';
header('Content-Type: application/json');

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['success' => false, 'error' => 'Sesión no iniciada']);
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$accion = $_POST['accion'] ?? '';

switch ($accion) {
    case 'crear_asunto':
        $titulo = trim($_POST['titulo'] ?? '');
        $mensaje = trim($_POST['mensaje'] ?? '');
        if ($titulo && $mensaje) {
            $stmt = $conn->prepare("INSERT INTO asuntos (titulo) VALUES (?)");
            $stmt->execute([$titulo]);
            $id_asunto = $conn->lastInsertId();

            $stmt = $conn->prepare("INSERT INTO mensajes (contenido, id_asunto, id_usuario) VALUES (?, ?, ?)");
            $stmt->execute([$mensaje, $id_asunto, $id_usuario]);

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Título o mensaje vacío']);
        }
        break;

    case 'obtener_asuntos':
        $stmt = $conn->query("SELECT * FROM asuntos ORDER BY id_asunto DESC");
        $asuntos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'asuntos' => $asuntos]);
        break;

    case 'obtener_mensajes':
        $id_asunto = $_POST['id_asunto'] ?? 0;
        $stmt = $conn->prepare("SELECT m.*, u.nombre FROM mensajes m JOIN usuarios u ON m.id_usuario = u.id_usuario WHERE m.id_asunto = ? ORDER BY m.fecha_mensaje ASC");
        $stmt->execute([$id_asunto]);
        $mensajes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($mensajes as &$m) {
            $m['propietario'] = ($m['id_usuario'] == $id_usuario);
        }
        echo json_encode(['success' => true, 'mensajes' => $mensajes]);
        break;

    case 'enviar_mensaje':
        $mensaje = trim($_POST['mensaje'] ?? '');
        $id_asunto = $_POST['id_asunto'] ?? 0;
        if ($mensaje && $id_asunto) {
            $stmt = $conn->prepare("INSERT INTO mensajes (contenido, id_asunto, id_usuario) VALUES (?, ?, ?)");
            $stmt->execute([$mensaje, $id_asunto, $id_usuario]);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
        }
        break;

    case 'eliminar_mensaje':
        $id_mensaje = $_POST['id_mensaje'] ?? 0;
        $stmt = $conn->prepare("DELETE FROM mensajes WHERE id_mensaje = ? AND id_usuario = ?");
        $stmt->execute([$id_mensaje, $id_usuario]);
        echo json_encode(['success' => true]);
        break;

    case 'eliminar_asunto':
        $id_asunto = $_POST['id_asunto'] ?? 0;
        $stmt = $conn->prepare("DELETE FROM asuntos WHERE id_asunto = ?");
        $stmt->execute([$id_asunto]);
        echo json_encode(['success' => true]);
        break;

    default:
        echo json_encode(['success' => false, 'error' => 'Acción no reconocida']);
}
