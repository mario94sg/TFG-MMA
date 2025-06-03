<?php
require_once 'database.php'; // tu conexión

header('Content-Type: application/json');

$sql = "SELECT id_evento, titulo, descripcion, fecha_evento, fecha_evento_fin FROM eventos";
$result = $conn->query($sql);

$eventos = [];

while ($fila = $result->fetch_assoc()) {
    $start = date('Y-m-d', strtotime($fila['fecha_evento']));
    $end = date('Y-m-d', strtotime($fila['fecha_evento_fin'] . ' +1 day')); // FullCalendar no incluye el último día

    $eventos[] = [
        'title' => $fila['titulo'],
        'start' => $start,
        'end'   => $end,
        'description' => $fila['descripcion']
    ];
}

echo json_encode($eventos);
