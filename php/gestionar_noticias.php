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

if ($accion === 'crear') {
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];

    $stmt = $conn->prepare("INSERT INTO noticias (titulo, contenido, id_entrenador) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $titulo, $contenido, $id_entrenador);
    $stmt->execute();

    echo json_encode(['success' => true]);
} elseif ($accion === 'obtener') {
    $sql = "SELECT n.*, u.nombre FROM noticias n JOIN usuarios u ON n.id_entrenador = u.id_usuario ORDER BY fecha_publicacion_noticia DESC";
    $res = $conn->query($sql);
    $noticias = [];
    while ($row = $res->fetch_assoc()) {
        $noticias[] = $row;
    }
    echo json_encode($noticias);
} elseif ($accion === 'eliminar') {
    $id = $_POST['id_noticia'];
    $stmt = $conn->prepare("DELETE FROM noticias WHERE id_noticia = ? AND id_entrenador = ?");
    $stmt->bind_param("ii", $id, $id_entrenador);
    $stmt->execute();
    echo json_encode(['success' => true]);
} elseif ($accion === 'editar') {
    $id = $_POST['id_noticia'];
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];

    $stmt = $conn->prepare("UPDATE noticias SET titulo = ?, contenido = ? WHERE id_noticia = ? AND id_entrenador = ?");
    $stmt->bind_param("ssii", $titulo, $contenido, $id, $id_entrenador);
    $stmt->execute();
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Acción no válida']);
}
