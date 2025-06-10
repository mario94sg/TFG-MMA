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
  <title>Ejercicios - Entrenador</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script>
    const userId = <?= json_encode($_SESSION['id_usuario']) ?>;
  </script>
  <script type="text/javascript" src="../../js/ejercicios_entrenador.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="../../css/ejercicios.css">

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
        <a class="navbar-brand fw-bold" href="ejercicios_entrenador.php">Ejercicios</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarEntrenador" aria-controls="navbarEntrenador" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navbarEntrenador">
          <ul class="navbar-nav">
            <li class="nav-item"><a href="vista_entrenador.php" class="nav-link">Inicio</a></li>
            <li class="nav-item"><a href="alumnos_entrenador.php" class="nav-link">Alumnos</a></li>
            <li class="nav-item"><a href="noticias_entrenador.php" class="nav-link">Noticias</a></li>
            <li class="nav-item"><a href="calendario_entrenador.php" class="nav-link">Calendario</a></li>
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
    <div class="card mb-4 shadow container mt-4">
      <div class="card-header bg-primary text-white container mt-4">Asignar nuevo ejercicio</div>
      <div class="card-body">
        <form id="form-ejercicio">
          <div class="mb-3">
            <label for="titulo" class="form-label">Título del ejercicio</label>
            <input type="text" id="titulo" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea id="descripcion" class="form-control" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Asignar a:</label>
            <div id="lista-alumnos" class="row"></div>
          </div>
          <button type="submit" class="btn btn-success">Asignar ejercicio</button>
        </form>
      </div>
    </div>
  </section>
  <section class="info-section bg-light py-5">
    <div class="card shadow container mt-4">
      <div class="card-body">
        <h5 class="section-title">Tabla de Ejercicios</h5>
        <div id="tabla-ejercicios" class="table-responsive"></div>
      </div>
    </div>
  </section>
  <!-- Modal de Confirmación de Eliminación -->
  <div class="modal fade" id="modalEliminarEjercicio" tabindex="-1" aria-labelledby="modalEliminarEjercicioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-danger">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="modalEliminarEjercicioLabel">Eliminar ejercicio</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          ¿Estás seguro de que deseas eliminar este ejercicio?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-danger" id="confirmarEliminarBtn">Eliminar</button>
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