<?php
session_start();
require_once 'database.php';

// Verificar sesión y tipo de usuario
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] !== 'entrenador') {
    http_response_code(403);
    echo json_encode(["error" => "Acceso denegado"]);
    exit();
}

$sql = "SELECT id_usuario, nombre, email, registrado FROM usuarios WHERE tipo = 'alumno'";
$resultado = $conn->query($sql);

$alumnos = [];
while ($row = $resultado->fetch_assoc()) {
    $alumnos[] = $row;
}

header('Content-Type: application/json');
echo json_encode($alumnos);
