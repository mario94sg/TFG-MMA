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
  <title>Calendario - Entrenador</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="../css/calendario_entrenador.css" />
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js"></script>
  <script src="../js/calendario_entrenador.js"></script>
</head>

<body>
  <div class="container mt-4">
    <h1 class="text-center mb-4">Tzinavos Team MMA Calendario - Entrenador <?= htmlspecialchars($_SESSION['nombre']) ?></h1>
    <nav class="mb-4 text-center">
      <a href="vista_entrenador.php" class="btn btn-outline-primary me-2">Inicio</a>
      <a href="noticias_entrenador.php" class="btn btn-outline-primary me-2">Noticias</a>
      <a href="alumnos_entrenador.php" class="btn btn-outline-primary me-2">Alumnos</a>
      <a href="calendario_entrenador.php" class="btn btn-primary me-2">Calendario</a>
      <a href="ejercicios_entrenador.php" class="btn btn-outline-primary me-2">Ejercicios</a>
      <a href="foro_entrenador.php" class="btn btn-outline-primary">Foro</a>
      <button class="btn btn-danger float-end" data-bs-toggle="modal" data-bs-target="#logoutModal">
        Cerrar sesión
      </button>
    </nav>

    <div id="calendar" class="mb-5"></div>

    <h3>Gestión de eventos</h3>
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
</body>

</html>