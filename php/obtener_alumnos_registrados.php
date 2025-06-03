<?php
require_once "database.php";
header("Content-Type: application/json");

$resultado = $conn->query("SELECT id_usuario, nombre FROM usuarios WHERE tipo = 'alumno' AND registrado = 1 ORDER BY nombre");

$alumnos = [];
while ($row = $resultado->fetch_assoc()) {
    $alumnos[] = $row;
}

echo json_encode($alumnos);