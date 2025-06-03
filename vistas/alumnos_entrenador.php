<?php
$tipoEsperado = "entrenador";
require_once "../php/verificar_sesion.php";
include "../php/modal_logout.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Alumnos - Entrenador</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script type="text/javascript" src="../js/alumnos_entrenador.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/alumnos_entrenador.css">
</head>

<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Tzinavos Team MMA Alumnos - Entrenador <?= htmlspecialchars($_SESSION['nombre']) ?></h1>
        <nav class="mb-4 text-center">
            <a href="vista_entrenador.php" class="btn btn-outline-primary me-2">Inicio</a>
            <a href="noticias_entrenador.php" class="btn btn-outline-primary me-2">Noticias</a>
            <a href="alumnos_entrenador.php" class="btn btn-primary me-2">Alumnos</a>
            <a href="calendario_entrenador.php" class="btn btn-outline-primary me-2">Calendario</a>
            <a href="ejercicios_entrenador.php" class="btn btn-outline-primary me-2">Ejercicios</a>
            <a href="foro_entrenador.php" class="btn btn-outline-primary">Foro</a>
            <button class="btn btn-danger float-end" data-bs-toggle="modal" data-bs-target="#logoutModal">
                Cerrar sesión
            </button>
        </nav>

        <div class="card shadow">
            <div class="card-body">
                <h5 class="card-title text-center mb-4">Lista de Alumnos</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="alumnos-lista"></tbody>
                    </table>
                </div>
                <button id="btn-agregar-alumno" class="btn btn-primary mt-3">Agregar Alumno</button>
            </div>
        </div>

        <div id="formulario-alumno" class="mt-4" style="display: none;">
            <h3>Agregar Alumno</h3>
            <form id="form-alumno">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="contrasena" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="contrasena" required>
                </div>
                <button type="submit" class="btn btn-success">Guardar</button>
                <button type="button" id="btn-cancelar" class="btn btn-secondary">Cancelar</button>
            </form>
        </div>

        <!-- Modales-->
        <div class="modal fade" id="modalConfirmacionEliminar" tabindex="-1" aria-labelledby="modalConfirmacionLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="modalConfirmacionLabel">Confirmar eliminación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">¿Estás seguro de que deseas eliminar este alumno? Esta acción no se puede deshacer.</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="confirmarEliminarBtn">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalFeedback" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title" id="modalFeedbackTitulo">Información</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="modalFeedbackMensaje">
                        Mensaje de ejemplo.
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

</html>
