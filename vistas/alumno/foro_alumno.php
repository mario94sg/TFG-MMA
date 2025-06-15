<?php
$tipoEsperado = "alumno";
require_once "../../controlador/verificar_sesion.php";
include "../componentes/modal_logout.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Foro - Alumno</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../js/foro_alumno.js"></script>
  <link rel="stylesheet" href="../../css/foro.css">
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
        <a class="navbar-brand fw-bold" href="foro_alumno.php">Foro</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarEntrenador" aria-controls="navbarEntrenador" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navbarEntrenador">
          <ul class="navbar-nav">
            <li class="nav-item"><a href="vista_alumno.php" class="nav-link">Inicio</a></li>
            <li class="nav-item"><a href="noticias_alumno.php" class="nav-link">Noticias</a></li>
            <li class="nav-item"><a href="calendario_alumno.php" class="nav-link">Calendario</a></li>
            <li class="nav-item"><a href="ejercicios_alumno.php" class="nav-link">Ejercicios</a></li>
            <li class="nav-item"><a href="nutricion_alumno.php" class="nav-link">Nutrición</a></li>
          </ul>
          <button class="btn btn-danger ms-auto" data-bs-toggle="modal" data-bs-target="#logoutModal">
            Cerrar sesión
          </button>
        </div>
      </div>
    </nav>
  </div>
  <section class="info-section bg-light py-5">
    <div class="container mt-4">
      <div class="row g-4 align-items-start">
        <div id="asuntos-container" class="col-md-6 d-flex flex-wrap gap-2">
          <!-- Aquí irán los asuntos -->
        </div>
        <div class="col-md-6">
          <form id="form-nuevo-asunto" class="formulario-container">
            <h2 class="section-title">Crear nueva conversacion</h2>
            <div class="mb-2">
              <input type="text" class="form-control" id="titulo_asunto" placeholder="Nuevo Asunto" required />
            </div>
            <div>
              <textarea class="form-control" id="mensaje_inicial" rows="2" placeholder="Mensaje inicial..." required></textarea>
            </div>
            <button type="submit" class="btn btn-success mt-2 w-100">Crear asunto</button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <section class="info-section bg-light py-5">
    <div class="container mt-4">
      <h2 class="section-title">Conversaciones</h2>
      <div id="conversaciones" class="accordion"></div>
    </div>
  </section>


  <!-- Modales -->
  <div class="modal fade" id="modalAlert" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Mensaje</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" id="modalAlertBody"></div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalConfirmarEliminar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Confirmar eliminación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          ¿Estás seguro de que deseas eliminar este mensaje?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">Eliminar</button>
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