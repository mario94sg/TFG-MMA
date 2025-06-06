<?php
require_once 'database.php'; 

header('Content-Type: application/json');

try {
    $sql = "SELECT id_evento, titulo, descripcion, fecha_evento, fecha_evento_fin FROM eventos";
    $stmt = $conn->query($sql);
    $eventos = [];

    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $start = date('Y-m-d', strtotime($fila['fecha_evento']));
        $end = date('Y-m-d', strtotime($fila['fecha_evento_fin'] . ' +1 day'));

        $eventos[] = [
            'title' => $fila['titulo'],
            'start' => $start,
            'end' => $end,
            'description' => $fila['descripcion']
        ];
    }

    echo json_encode($eventos);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al obtener eventos: ' . $e->getMessage()]);
}
