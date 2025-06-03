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
  <title>Ejercicios - Alumno</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/ejercicios_alumno.css" />

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script type="text/javascript" src="../js/ejercicios_alumno.js"></script>

</head>

<body>
  <div class="container mt-4">
    <h1 class="text-center mb-4">Tzinavos Team MMA Ejercicios - Alumno <?= htmlspecialchars($_SESSION['nombre']) ?></h1>
    <nav class="mb-4 text-center">
      <a href="vista_alumno.php" class="btn btn-outline-primary me-2">Inicio</a>
      <a href="noticias_alumno.php" class="btn btn-outline-primary me-2">Noticias</a>
      <a href="calendario_alumno.php" class="btn btn-outline-primary me-2">Calendario</a>
      <a href="ejercicios_alumno.php" class="btn btn-primary me-2">Ejercicios</a>
      <a href="foro_alumno.php" class="btn btn-outline-primary">Foro</a>
      <button class="btn btn-danger float-end" data-bs-toggle="modal" data-bs-target="#logoutModal">
        Cerrar sesión
      </button>
    </nav>
   
    <div class="card">
      <div class="card-body">
        <h5 class="card-title text-center mb-4">Tabla de Ejercicios</h5>
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
  </div>
  </div>
</body>

</html>