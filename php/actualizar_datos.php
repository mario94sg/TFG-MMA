<?php
session_start();
require_once '../php/database.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] !== 'alumno') {
    header("Location: ../index.html");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

$sql = "SELECT nombre, email FROM usuarios WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Actualizar Datos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../js/actualizar_datos.js"></script>
    <style>
        #passwordHelp {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Actualizar Datos del Alumno</h2>
        <form id="formActualizar" method="POST" action="procesar_actualizacion.php">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email (no editable)</label>
                <input type="email" name="correo" class="form-control" value="<?= htmlspecialchars($usuario['email']) ?>" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Nueva Contraseña</label>
                <input type="password" name="contrasena" class="form-control" required>
                <div id="passwordHelp">
                    La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.
                </div>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-success">Actualizar</button>
            </div>
        </form>
    </div>

    <!-- Modal Bootstrap -->
    <div class="modal fade" id="modalMensaje" tabindex="-1" aria-labelledby="modalMensajeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalMensajeLabel">Mensaje</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" id="modalCuerpoMensaje"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
