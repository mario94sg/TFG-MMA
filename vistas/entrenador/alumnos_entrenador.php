<?php
$tipoEsperado = "entrenador";
require_once "../../controlador/verificar_sesion.php";
include "../componentes/modal_logout.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Alumnos - Entrenador</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script type="text/javascript" src="../../js/alumnos_entrenador.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../css/alumnos_entrenador.css">
</head>

<body>
    <header class="header-container">
        <div class="container d-flex flex-column flex-md-row align-items-center justify-content-center gap-3">
            <div class="logo-box">
                <img src="../../media/images/logo.jpeg" alt="logo" />
            </div>
            <h1 class="main-title text-center">TZINAVOS TEAM MMA <?= htmlspecialchars($_SESSION['nombre']) ?></h1>
        </div>
    </header>
    <div class="container mt-4">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark rounded px-3">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="alumnos_entrenador.php">Alumnos</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarEntrenador" aria-controls="navbarEntrenador" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="navbarEntrenador">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a href="vista_entrenador.php" class="nav-link">Inicio</a></li>
                        <li class="nav-item"><a href="noticias_entrenador.php" class="nav-link">Noticias</a></li>
                        <li class="nav-item"><a href="calendario_entrenador.php" class="nav-link">Calendario</a></li>
                        <li class="nav-item"><a href="ejercicios_entrenador.php" class="nav-link">Ejercicios</a></li>
                        <li class="nav-item"><a href="foro_entrenador.php" class="nav-link">Foro</a></li>
                        <li class="nav-item"><a href="nutricion_entrenador.php" class="nav-link">Nutrición</a></li>
                    </ul>
                    <button class="btn btn-danger ms-auto" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        Cerrar sesión
                    </button>
                </div>
            </div>
        </nav>
    </div>
    <section class="info-section bg-light py-5">
        <div class="card shadow container mt-4">
            <div class="card-body">
                <h2 class="section-title">Lista de Alumnos</h2>
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
    </section>
    <section id="seccion-formulario" class="info-section bg-light py-5 d-none">
        <div class="container mt-4">
            <div id="formulario-alumno" class="mt-4" class="formulario-container">
                <h2 class="section-title">Agregar Alumno</h2>
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
        </div>
    </section>

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


    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
            <img src="../../media/images/mirmidones.jpeg" alt="mirmidones" class="footer-img mb-3 mb-md-0">
            <div class="text-center mx-md-5">
                <h3 class="fw-bold">¡Contacta con el maestro!</h3>
                <p>Tlf: 652 91 31 27 </p>
                <p>Email maestro: tzinavosteam@hotmail.com</p>
                <p>Email para ayuda de la web: support@tzinavosteam.online</p>
            </div>
            <img src="../../media/images/pankrationw.jpeg" alt="pankration" class="footer-img mb-3 mb-md-0">
        </div>
    </footer>
</body>

</html>