<?php
session_start();
require_once 'database.php';


if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] !== 'entrenador') {
    http_response_code(403);
    echo json_encode(["error" => "Acceso denegado"]);
    exit();
}

try {
    $sql = "SELECT id_usuario, nombre, email, registrado FROM usuarios WHERE tipo = 'alumno'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($alumnos);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error al consultar alumnos: " . $e->getMessage()]);
}
