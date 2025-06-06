<?php
session_start();
require_once "database.php";

header('Content-Type: application/json');

$id_entrenador = $_SESSION['id_usuario'] ?? null;

if (!$id_entrenador) {
    echo json_encode(['error' => 'No autenticado']);
    exit;
}

$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

try {
    if ($accion === 'crear') {
        $titulo = $_POST['titulo'] ?? '';
        $contenido = $_POST['contenido'] ?? '';

        $stmt = $conn->prepare("INSERT INTO noticias (titulo, contenido, id_entrenador) VALUES (:titulo, :contenido, :id_entrenador)");
        $stmt->execute([
            ':titulo' => $titulo,
            ':contenido' => $contenido,
            ':id_entrenador' => $id_entrenador
        ]);

        echo json_encode(['success' => true]);
    } elseif ($accion === 'obtener') {
        $stmt = $conn->query("SELECT n.*, u.nombre FROM noticias n JOIN usuarios u ON n.id_entrenador = u.id_usuario ORDER BY fecha_publicacion_noticia DESC");
        $noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($noticias);
    } elseif ($accion === 'eliminar') {
        $id = $_POST['id_noticia'] ?? 0;

        $stmt = $conn->prepare("DELETE FROM noticias WHERE id_noticia = :id AND id_entrenador = :id_entrenador");
        $stmt->execute([
            ':id' => $id,
            ':id_entrenador' => $id_entrenador
        ]);

        echo json_encode(['success' => true]);
    } elseif ($accion === 'editar') {
        $id = $_POST['id_noticia'] ?? 0;
        $titulo = $_POST['titulo'] ?? '';
        $contenido = $_POST['contenido'] ?? '';

        $stmt = $conn->prepare("UPDATE noticias SET titulo = :titulo, contenido = :contenido WHERE id_noticia = :id AND id_entrenador = :id_entrenador");
        $stmt->execute([
            ':titulo' => $titulo,
            ':contenido' => $contenido,
            ':id' => $id,
            ':id_entrenador' => $id_entrenador
        ]);

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Acción no válida']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
}
