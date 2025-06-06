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

try {
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id_usuario = :id AND tipo = 'alumno'");
    $stmt->execute([':id' => $id]);

    if ($stmt->rowCount() > 0) {
        echo "Alumno eliminado.";
    } else {
        http_response_code(404);
        echo "No se encontró el alumno o no se pudo eliminar.";
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo "Error al eliminar alumno: " . $e->getMessage();
}
