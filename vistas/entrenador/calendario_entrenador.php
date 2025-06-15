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
  <title>Calendario - Entrenador</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="../../css/calendario_entrenador.css" />

  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js"></script>

  <script src="../../js/calendario_entrenador.js"></script>

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
        <a class="navbar-brand fw-bold" href="calendario_entrenador.php">Calendario</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarEntrenador" aria-controls="navbarEntrenador" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navbarEntrenador">
          <ul class="navbar-nav">
            <li class="nav-item"><a href="vista_entrenador.php" class="nav-link">Inicio</a></li>
            <li class="nav-item"><a href="alumnos_entrenador.php" class="nav-link">Alumnos</a></li>
            <li class="nav-item"><a href="noticias_entrenador.php" class="nav-link">Noticias</a></li>
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
    <div class="container mt-4">
      <div id="calendar" class="mb-5"></div>
    </div>
  </section>

  <section class="info-section bg-light py-5">
    <div class="formulario-container">
      <h2 class="section-title">Gestión de eventos</h2>
      <form id="form-evento" class="mb-3">
        <input type="hidden" id="id_evento">
        <div class="row">
          <div class="col-md-3"><input type="text" class="form-control" id="titulo" placeholder="Título" required></div>
          <div class="col-md-3"><input type="text" class="form-control" id="descripcion" placeholder="Descripción" required></div>
          <div class="col-md-3"><input type="date" class="form-control" id="fecha_inicio" required></div>
          <div class="col-md-3"><input type="date" class="form-control" id="fecha_fin" required></div>
        </div>
        <button type="submit" class="btn btn-success mt-2">Guardar evento</button>
      </form>
    </div>
  </section>

  <section class="info-section bg-light py-5">
    <div class="container mt-4">
      <h2 class="section-title">Lista de eventos</h2>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Título</th>
              <th>Descripción</th>
              <th>Inicio</th>
              <th>Fin</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody id="tabla-eventos"></tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- Modales -->
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


  <div class="modal fade" id="modalConfirmacion" tabindex="-1" aria-labelledby="modalConfirmacionLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="modalConfirmacionLabel">Confirmar acción</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" id="modalCuerpoConfirmacion">¿Estás seguro de que deseas continuar?</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">Sí, eliminar</button>
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