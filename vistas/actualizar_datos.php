<?php
session_start();
require_once '../modelo/database.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] !== 'alumno') {
    header("Location: ../index.html");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

try {
    $stmt = $conn->prepare("SELECT nombre, email FROM usuarios WHERE id_usuario = :id");
    $stmt->execute([':id' => $id_usuario]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        throw new Exception("Usuario no encontrado.");
    }
} catch (Exception $e) {
    echo "<p>Error al cargar datos: " . htmlspecialchars($e->getMessage()) . "</p>";
    exit();
}
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
    <link rel="stylesheet" href="../css/actualizar_datos.css" />
    <style>
        #passwordHelp {
            font-size: 0.9rem;
            color: white;
        }
    </style>
</head>

<body>
    <header class="header-container">
        <div class="container d-flex flex-column flex-md-row align-items-center justify-content-center gap-3">
            <div class="logo-box">
                <img src="../media/images/logo.jpeg" alt="logo" />
            </div>
            <h1 class="main-title text-center">TZINAVOS TEAM MMA</h1>
        </div>
    </header>
    <section class="info-section bg-light py-5">
        <div class="container mt-5">
            <h2 class="section-title">Actualiza tus Datos</h2>
            <form id="formActualizar" method="POST" action="procesar_actualizacion.php" class="formulario-container">
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
    </section>
    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
            <img src="../media/images/mirmidones.jpeg" alt="mirmidones" class="footer-img mb-3 mb-md-0">
            <div class="text-center mx-md-5">
                <h3 class="fw-bold">¡Contacta con nosotros!</h3>
                <p>Tlf: 652 91 31 27 </p>
                <p>Email entrenador: tzinavosteam@hotmail.com</p>
                <p>Email para ayuda de la web: support@tzinavosteam.online</p>
            </div>
            <img src="../media/images/pankrationw.jpeg" alt="pankration" class="footer-img mb-3 mb-md-0">
        </div>
    </footer>
    <!-- Modal -->
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