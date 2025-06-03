<?php
session_start();
require_once 'database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] !== 'entrenador') {
    http_response_code(403);
    echo json_encode(['error' => 'Acceso denegado']);
    exit;
}

$id_entrenador = $_SESSION['id_usuario'];
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $sql = "SELECT id_evento, titulo, descripcion, fecha_evento, fecha_evento_fin FROM eventos WHERE id_entrenador = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_entrenador);
    $stmt->execute();
    $result = $stmt->get_result();

    $eventos = [];
    while ($row = $result->fetch_assoc()) {
        $eventos[] = [
            'id' => $row['id_evento'],
            'title' => $row['titulo'],
            'description' => $row['descripcion'],
            'start' => date('Y-m-d', strtotime($row['fecha_evento'])),
            'end' => date('Y-m-d', strtotime($row['fecha_evento_fin'] . ' +1 day')),
        ];
    }

    echo json_encode($eventos);
    exit;
}

if ($method === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'guardar') {
        $id = $_POST['id_evento'];
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $fecha_inicio = $_POST['fecha_evento'];
        $fecha_fin = $_POST['fecha_evento_fin'];

        if ($id) {
            $sql = "UPDATE eventos SET titulo=?, descripcion=?, fecha_evento=?, fecha_evento_fin=? WHERE id_evento=? AND id_entrenador=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssii", $titulo, $descripcion, $fecha_inicio, $fecha_fin, $id, $id_entrenador);
        } else {
            $sql = "INSERT INTO eventos (titulo, descripcion, fecha_evento, fecha_evento_fin, id_entrenador) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $titulo, $descripcion, $fecha_inicio, $fecha_fin, $id_entrenador);
        }

        $stmt->execute();
        echo json_encode(['success' => true]);
        exit;
    }

    if ($action === 'eliminar') {
        $id = $_POST['id_evento'];
        $sql = "DELETE FROM eventos WHERE id_evento=? AND id_entrenador=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $id, $id_entrenador);
        $stmt->execute();
        echo json_encode(['success' => true]);
        exit;
    }
}
