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
  <title>Ejercicios - Alumno</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../../css/ejercicios.css" />

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script type="text/javascript" src="../../js/ejercicios_alumno.js"></script>

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
        <a class="navbar-brand fw-bold" href="ejercicios_alumno.php">Ejercicios</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarEntrenador" aria-controls="navbarEntrenador" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navbarEntrenador">
          <ul class="navbar-nav">
            <li class="nav-item"><a href="vista_alumno.php" class="nav-link">Inicio</a></li>
            <li class="nav-item"><a href="noticias_alumno.php" class="nav-link">Noticias</a></li>
            <li class="nav-item"><a href="calendario_alumno.php" class="nav-link">Calendario</a></li>
            <li class="nav-item"><a href="foro_alumno.php" class="nav-link">Foro</a></li>
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
    <div class="card container mt-4 shadow">
      <div class="card-body">
        <h5 class="section-title">Tabla de Ejercicios</h5>
        <div class="table-responsive">
          <table class="table table-bordered table-hover text-center align-middle" id="tablaEjerciciosAlumno">
            <thead class="table-dark">
              <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Fecha asignación</th>
                <th>Estado</th>
                <th>Completar</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>


  <!-- Modal Confirmación -->
  <div class="modal fade" id="modalConfirmarCompletar" tabindex="-1" aria-labelledby="modalCompletarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-warning text-dark">
          <h5 class="modal-title" id="modalCompletarLabel">Confirmar acción</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          ¿Estás seguro de que quieres marcar este ejercicio como completado?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-success" id="confirmarCompletar">Sí, marcar</button>
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