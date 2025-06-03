<?php
session_start();
require_once "database.php";
header('Content-Type: application/json');

$accion = $_REQUEST['accion'] ?? '';

$id_usuario = $_SESSION['id_usuario'] ?? null;

if (!$id_usuario) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

if ($accion === "insertar" && isset($_POST['contenido'])) {
    $contenido = trim($_POST['contenido']);

    if ($contenido === "") {
        http_response_code(400);
        echo json_encode(['error' => 'El contenido está vacío']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO foro (contenido, id_usuario) VALUES (?, ?)");
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => "Error preparando: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("si", $contenido, $id_usuario);
    if (!$stmt->execute()) {
        http_response_code(500);
        echo json_encode(['error' => "Error ejecutando: " . $stmt->error]);
        exit;
    }

    echo json_encode(['estado' => 'ok']);
    exit;
}

if ($accion === "listar") {
    $result = $conn->query("
        SELECT f.id_mensaje, f.contenido, f.fecha_mensaje, f.id_usuario, u.nombre
        FROM foro f
        JOIN usuarios u ON f.id_usuario = u.id_usuario
        ORDER BY f.fecha_mensaje DESC
    ");

    if (!$result) {
        http_response_code(500);
        echo json_encode(['error' => "Error consultando: " . $conn->error]);
        exit;
    }

    $mensajes = [];
    while ($row = $result->fetch_assoc()) {
        $mensajes[] = $row;
    }

    echo json_encode($mensajes);
    exit;
}

if ($accion === "eliminar" && isset($_POST['id_mensaje'])) {
    $id_mensaje = intval($_POST['id_mensaje']);

    $stmt = $conn->prepare("DELETE FROM foro WHERE id_mensaje = ? AND id_usuario = ?");
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => "Error preparando: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("ii", $id_mensaje, $id_usuario);
    if (!$stmt->execute()) {
        http_response_code(500);
        echo json_encode(['error' => "Error ejecutando: " . $stmt->error]);
        exit;
    }

    echo json_encode(['estado' => 'ok']);
    exit;
}

http_response_code(400);
echo json_encode(['error' => 'Acción no válida']);
exit;