<?php
session_start();
require_once "database.php";
header("Content-Type: application/json");

$id_usuario = $_SESSION["id_usuario"] ?? null;
$tipo = $_SESSION["tipo"] ?? null;
$accion = $_REQUEST["accion"] ?? "";

if (!$id_usuario || !$tipo) {
    echo json_encode(["error" => "No autorizado"]);
    exit;
}

// ASIGNAR EJERCICIO
if ($accion === "asignar" && $tipo === "entrenador") {
    $titulo = trim($_POST["titulo"] ?? "");
    $descripcion = trim($_POST["descripcion"] ?? "");
    $alumnos = $_POST["alumnos"] ?? [];

    if (!$titulo || !$descripcion || !count($alumnos)) {
        echo json_encode(["error" => "Datos incompletos"]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO ejercicios_asignados (titulo, descripcion, id_alumno, id_entrenador) VALUES (?, ?, ?, ?)");
    foreach ($alumnos as $alumno) {
        $stmt->bind_param("ssii", $titulo, $descripcion, $alumno, $id_usuario);
        $stmt->execute();
    }

    echo json_encode(["estado" => "ok"]);
    exit;
}

// LISTAR EJERCICIOS
if ($accion === "listar") {
    if ($tipo === "entrenador") {
        $sql = "
            SELECT e.*, u.nombre AS nombre_alumno
            FROM ejercicios_asignados e
            JOIN usuarios u ON e.id_alumno = u.id_usuario
            ORDER BY e.fecha_asignacion DESC
        ";
    } elseif ($tipo === "alumno") {
        $sql = "
            SELECT e.*, u.nombre AS nombre_entrenador
            FROM ejercicios_asignados e
            JOIN usuarios u ON e.id_entrenador = u.id_usuario
            WHERE e.id_alumno = $id_usuario
            ORDER BY e.fecha_asignacion DESC
        ";
    } else {
        echo json_encode(["error" => "Tipo de usuario inválido"]);
        exit;
    }

    $result = $conn->query($sql);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
    exit;
}

// ELIMINAR
if ($accion === "eliminar" && $tipo === "entrenador") {
    $id_ejercicio = intval($_POST["id_ejercicio"]);
    $stmt = $conn->prepare("DELETE FROM ejercicios_asignados WHERE id_ejercicio = ?");
    $stmt->bind_param("i", $id_ejercicio);
    $stmt->execute();
    echo json_encode(["estado" => "ok"]);
    exit;
}

// MARCAR COMO COMPLETADO (desde alumno)
if ($accion === "completar" && $tipo === "alumno") {
    $id_ejercicio = intval($_POST["id_ejercicio"]);
    $stmt = $conn->prepare("UPDATE ejercicios_asignados SET completado = 1, fecha_completado = NOW() WHERE id_ejercicio = ? AND id_alumno = ?");
    $stmt->bind_param("ii", $id_ejercicio, $id_usuario);
    $stmt->execute();
    echo json_encode(["estado" => "ok"]);
    exit;
}

echo json_encode(["error" => "Acción no válida"]);
