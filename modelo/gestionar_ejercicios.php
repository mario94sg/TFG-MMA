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

try {

    if ($accion === "asignar" && $tipo === "entrenador") {
        $titulo = trim($_POST["titulo"] ?? "");
        $descripcion = trim($_POST["descripcion"] ?? "");
        $alumnos = $_POST["alumnos"] ?? [];

        if (!$titulo || !$descripcion || !count($alumnos)) {
            echo json_encode(["error" => "Datos incompletos"]);
            exit;
        }

        $stmt = $conn->prepare("
            INSERT INTO ejercicios_asignados (titulo, descripcion, id_alumno, id_entrenador) 
            VALUES (:titulo, :descripcion, :id_alumno, :id_entrenador)
        ");

        foreach ($alumnos as $alumno) {
            $stmt->execute([
                ':titulo' => $titulo,
                ':descripcion' => $descripcion,
                ':id_alumno' => $alumno,
                ':id_entrenador' => $id_usuario
            ]);
        }

        echo json_encode(["estado" => "ok"]);
        exit;
    }


    if ($accion === "listar") {
        if ($tipo === "entrenador") {
            $sql = "
                SELECT e.*, u.nombre AS nombre_alumno
                FROM ejercicios_asignados e
                JOIN usuarios u ON e.id_alumno = u.id_usuario
                ORDER BY e.fecha_asignacion DESC
            ";
            $stmt = $conn->query($sql);
        } elseif ($tipo === "alumno") {
            $sql = "
                SELECT e.*, u.nombre AS nombre_entrenador
                FROM ejercicios_asignados e
                JOIN usuarios u ON e.id_entrenador = u.id_usuario
                WHERE e.id_alumno = :id_alumno
                ORDER BY e.fecha_asignacion DESC
            ";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':id_alumno' => $id_usuario]);
        } else {
            echo json_encode(["error" => "Tipo de usuario inválido"]);
            exit;
        }

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($data);
        exit;
    }


    if ($accion === "eliminar" && $tipo === "entrenador") {
        $id_ejercicio = intval($_POST["id_ejercicio"]);
        $stmt = $conn->prepare("DELETE FROM ejercicios_asignados WHERE id_ejercicio = :id_ejercicio");
        $stmt->execute([':id_ejercicio' => $id_ejercicio]);
        echo json_encode(["estado" => "ok"]);
        exit;
    }


    if ($accion === "completar" && $tipo === "alumno") {
        $id_ejercicio = intval($_POST["id_ejercicio"]);
        $stmt = $conn->prepare("
            UPDATE ejercicios_asignados 
            SET completado = 1, fecha_completado = NOW() 
            WHERE id_ejercicio = :id_ejercicio AND id_alumno = :id_alumno
        ");
        $stmt->execute([
            ':id_ejercicio' => $id_ejercicio,
            ':id_alumno' => $id_usuario
        ]);
        echo json_encode(["estado" => "ok"]);
        exit;
    }

    echo json_encode(["error" => "Acción no válida"]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error en la base de datos: " . $e->getMessage()]);
}
