<?php
$tipoEsperado = "alumno";
require_once "../php/verificar_sesion.php";
include "../php/modal_logout.php"; 
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Calendario - Alumno</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script type="text/javascript" src="../js/calendario_alumno.js"></script>
  <link rel="stylesheet" href="../css/calendario_alumno.css" />
  <!-- FullCalendar 5 -->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js"></script>

</head>

<body>
  <div class="container mt-4">
    <h1 class="text-center mb-4">Tzinavos Team MMA Calendario - Alumno <?= htmlspecialchars($_SESSION['nombre']) ?></h1>
    <nav class="mb-4 text-center">
      <a href="vista_alumno.php" class="btn btn-outline-primary me-2">Inicio</a>
      <a href="noticias_alumno.php" class="btn btn-outline-primary me-2">Noticias</a>
      <a href="calendario_alumno.php" class="btn btn-primary me-2">Calendario</a>
      <a href="ejercicios_alumno.php" class="btn btn-outline-primary me-2">Ejercicios</a>
      <a href="foro_alumno.php" class="btn btn-outline-primary">Foro</a>
      <button class="btn btn-danger float-end" data-bs-toggle="modal" data-bs-target="#logoutModal">
        Cerrar sesión
      </button>
    </nav>
    <div id="calendar"></div>
  </div>
</body>

</html>