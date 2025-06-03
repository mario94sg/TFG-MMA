<?php
session_start();
require_once 'database.php';

// Verificar sesión y tipo de usuario
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] !== 'entrenador') {
    http_response_code(403);
    echo "Acceso denegado.";
    exit();
}

if (!isset($_POST['id'])) {
    http_response_code(400);
    echo "ID no proporcionado.";
    exit();
}

$id = intval($_POST['id']);

$sql = "DELETE FROM usuarios WHERE id_usuario = ? AND tipo = 'alumno'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Alumno eliminado.";
} else {
    http_response_code(500);
    echo "Error al eliminar alumno: " . $stmt->error;
}
