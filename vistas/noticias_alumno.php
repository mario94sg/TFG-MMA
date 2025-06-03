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
  <title>Noticias - Alumno</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script type="text/javascript" src="../js/noticias_alumno.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="../css/noticias_alumno.css">
</head>

<body>

  <div class="container mt-4">
    <h1 class="text-center mb-4">Tzinavos Team MMA Noticias - Alumno <?= htmlspecialchars($_SESSION['nombre']) ?></h1>
    <nav class="mb-4 text-center">
      <a href="vista_alumno.php" class="btn btn-outline-primary me-2">Inicio</a>
      <a href="noticias_alumno.php" class="btn btn-primary me-2">Noticias</a>
      <a href="calendario_alumno.php" class="btn btn-outline-primary me-2">Calendario</a>
      <a href="ejercicios_alumno.php" class="btn btn-outline-primary me-2">Ejercicios</a>
      <a href="foro_alumno.php" class="btn btn-outline-primary">Foro</a>
      <button class="btn btn-danger float-end" data-bs-toggle="modal" data-bs-target="#logoutModal">
        Cerrar sesión
      </button>
    </nav>
  </div>
  <!-- Blog de noticias -->
  <div id="listaNoticias" class="row row-cols-1 g-4">
  </div>
</body>

</html>