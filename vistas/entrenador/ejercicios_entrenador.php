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
  <link rel="stylesheet" href="../../css/ejercicios_entrenador.css">

</head>

<body>

  <div class="container mt-4">
    <h1 class="text-center mb-4">Tzinavos Team MMA Ejercicios - Entrenador <?= htmlspecialchars($_SESSION['nombre']) ?></h1>
    <nav class="mb-4 text-center">
      <a href="vista_entrenador.php" class="btn btn-outline-primary me-2">Inicio</a>
      <a href="noticias_entrenador.php" class="btn btn-outline-primary me-2">Noticias</a>
      <a href="alumnos_entrenador.php" class="btn btn-outline-primary me-2">Alumnos</a>
      <a href="calendario_entrenador.php" class="btn btn-outline-primary me-2">Calendario</a>
      <a href="ejercicios_entrenador.php" class="btn btn-primary me-2">Ejercicios</a>
      <a href="foro_entrenador.php" class="btn btn-outline-primary">Foro</a>
      <a href="nutricion_entrenador.php" class="btn btn-outline-primary">Nutrición</a>
      <button class="btn btn-danger float-end" data-bs-toggle="modal" data-bs-target="#logoutModal">
        Cerrar sesión
      </button>
    </nav>

    <div class="card mb-4 shadow">
      <div class="card-header bg-primary text-white">Asignar nuevo ejercicio</div>
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
    <div class="card shadow">
      <div class="card-body">
        <h5 class="card-title text-center mb-4">Tabla de Ejercicios</h5>
        <div id="tabla-ejercicios" class="table-responsive"></div>
      </div>
    </div>

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
</body>

</html>