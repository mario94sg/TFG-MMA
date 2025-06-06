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

try {
    if ($method === 'GET') {
        // Obtener eventos ordenados por fecha, primero los futuros y luego los pasados
        $stmt = $conn->prepare("
            (
                SELECT id_evento, titulo, descripcion, fecha_evento, fecha_evento_fin
                FROM eventos
                WHERE id_entrenador = :id_entrenador AND fecha_evento_fin >= CURDATE()
                ORDER BY fecha_evento ASC
            )
            UNION ALL
            (
                SELECT id_evento, titulo, descripcion, fecha_evento, fecha_evento_fin
                FROM eventos
                WHERE id_entrenador = :id_entrenador AND fecha_evento_fin < CURDATE()
                ORDER BY fecha_evento ASC
            )
        ");
        $stmt->execute([':id_entrenador' => $id_entrenador]);

        $eventos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
            $id = $_POST['id_evento'] ?? null;
            $titulo = $_POST['titulo'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            $fecha_inicio = $_POST['fecha_evento'] ?? '';
            $fecha_fin = $_POST['fecha_evento_fin'] ?? '';

            if ($id) {
                // Actualizar evento
                $stmt = $conn->prepare("
                    UPDATE eventos 
                    SET titulo = :titulo, descripcion = :descripcion, fecha_evento = :fecha_inicio, fecha_evento_fin = :fecha_fin 
                    WHERE id_evento = :id AND id_entrenador = :id_entrenador
                ");
                $stmt->execute([
                    ':titulo' => $titulo,
                    ':descripcion' => $descripcion,
                    ':fecha_inicio' => $fecha_inicio,
                    ':fecha_fin' => $fecha_fin,
                    ':id' => $id,
                    ':id_entrenador' => $id_entrenador
                ]);
            } else {
                // Insertar nuevo evento
                $stmt = $conn->prepare("
                    INSERT INTO eventos (titulo, descripcion, fecha_evento, fecha_evento_fin, id_entrenador) 
                    VALUES (:titulo, :descripcion, :fecha_inicio, :fecha_fin, :id_entrenador)
                ");
                $stmt->execute([
                    ':titulo' => $titulo,
                    ':descripcion' => $descripcion,
                    ':fecha_inicio' => $fecha_inicio,
                    ':fecha_fin' => $fecha_fin,
                    ':id_entrenador' => $id_entrenador
                ]);
            }

            echo json_encode(['success' => true]);
            exit;
        }

        if ($action === 'eliminar') {
            $id = $_POST['id_evento'];
            $stmt = $conn->prepare("
                DELETE FROM eventos 
                WHERE id_evento = :id AND id_entrenador = :id_entrenador
            ");
            $stmt->execute([
                ':id' => $id,
                ':id_entrenador' => $id_entrenador
            ]);

            echo json_encode(['success' => true]);
            exit;
        }
    }

    http_response_code(400);
    echo json_encode(['error' => 'Acción o método no válido']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
}
