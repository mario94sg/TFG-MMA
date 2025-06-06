<?php
require_once "database.php";
header("Content-Type: application/json");

try {
    $stmt = $conn->query("SELECT id_usuario, nombre FROM usuarios WHERE tipo = 'alumno' AND registrado = 1 ORDER BY nombre");
    $alumnos = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $alumnos[] = $row;
    }

    echo json_encode($alumnos);
} catch (PDOException $e) {
    echo json_encode(["error" => "Error al obtener alumnos: " . $e->getMessage()]);
}
